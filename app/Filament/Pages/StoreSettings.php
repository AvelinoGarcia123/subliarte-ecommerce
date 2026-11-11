<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Models\Setting;
use App\Models\BankAccount;

class StoreSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.store-settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configuración de Tienda';
    protected static ?string $title = 'Configuración de la Tienda';
    protected static ?string $slug = 'configuracion-tienda';
    protected static ?int $navigationSort = 100; 

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->check(); 
    }

    public function mount(): void
    {
        $setting = Setting::firstOrCreate([]);
        $data = $setting->toArray();
        $data['bankAccounts'] = $setting->bankAccounts->toArray();
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Cuentas Bancarias (Pago Móvil / Transferencia)')
                    ->description('Agrega todas las cuentas que los clientes pueden usar para pagar.')
                    ->schema([
                        Repeater::make('bankAccounts')
                            ->schema([
                                TextInput::make('bank_name')
                                    ->label('Banco')
                                    ->placeholder('Ej: Banesco, Mercantil, BDV')
                                    ->required()
                                    ->regex('/^[\pL\s]+$/u') 
                                    ->validationMessages([
                                        'regex' => 'El nombre del banco solo puede contener letras y espacios.',
                                    ]),

                                Select::make('account_type')
                                    ->label('Tipo de Cuenta')
                                    ->options([
                                        'Pago Móvil' => 'Pago Móvil',
                                        'Transferencia' => 'Transferencia',
                                    ])
                                    ->required()
                                    ->live(),

                                TextInput::make('phone')
                                    ->label('Teléfono (Solo Pago Móvil)')
                                    ->placeholder('Ej: 04141234567')
                                    ->nullable() 
                                    ->numeric() 
                                    ->visible(fn ($get) => $get('account_type') === 'Pago Móvil')
                                    ->validationMessages([
                                        'numeric' => 'El teléfono solo puede contener números.',
                                    ]),

                                TextInput::make('id_number')
                                    ->label('Cédula o RIF (Solo Pago Móvil)')
                                    ->placeholder('Ej: V-27121305')
                                    ->nullable() 
                                    ->regex('/^[VEJPGvejpg]-?\d+$/') 
                                    ->visible(fn ($get) => $get('account_type') === 'Pago Móvil')
                                    ->validationMessages([
                                        'regex' => 'Formato inválido. Use V-12345678 o J-12345678.',
                                    ]),

                                TextInput::make('account_number')
                                    ->label('Número de Cuenta (Solo Transferencia)')
                                    ->placeholder('Ej: 0102-0000-00-0000000000')
                                    ->nullable() 
                                    ->regex('/^[0-9-]+$/') 
                                    ->visible(fn ($get) => $get('account_type') === 'Transferencia')
                                    ->validationMessages([
                                        'regex' => 'La cuenta solo puede contener números y guiones.',
                                    ]),

                                Toggle::make('is_active')
                                    ->label('Activa')
                                    ->default(true),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Agregar otra cuenta')
                            ->columnSpanFull(),
                    ]),

                Section::make('Redes Sociales')
                    ->description('Enlaces que aparecerán en el pie de página de la tienda.')
                    ->schema([
                        TextInput::make('whatsapp')
                            ->label('Número de WhatsApp')
                            ->prefix('https://wa.me/')
                            ->nullable()
                            ->numeric()
                            ->validationMessages([
                                'numeric' => 'El WhatsApp solo puede contener números.',
                            ]),
                        
                        TextInput::make('instagram')
                            ->label('Usuario de Instagram')
                            ->prefix('@')
                            ->nullable()
                            ->regex('/^[a-zA-Z0-9._]+$/')
                            ->validationMessages([
                                'regex' => 'El usuario de Instagram solo puede tener letras, números, puntos y guiones bajos.',
                            ]),
                            
                        TextInput::make('facebook')->label('Enlace o Nombre de Facebook')->nullable(),
                    ])->columns(3),

                Section::make('Promociones y Anuncios')
                    ->description('Mensaje que aparecerá en la parte superior de la tienda web.')
                    ->schema([
                        Textarea::make('promociones')->label('Texto de Promoción')->rows(3)->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $setting = Setting::firstOrCreate([]);
        
        $bankAccountsData = $data['bankAccounts'] ?? [];
        unset($data['bankAccounts']);

        $setting->update($data);

        $existingIds = $setting->bankAccounts->pluck('id')->toArray();
        $newIds = [];

        foreach ($bankAccountsData as $accountData) {
            if (isset($accountData['id']) && is_numeric($accountData['id'])) {
                $account = BankAccount::find($accountData['id']);
                if ($account) {
                    $account->update($accountData);
                    $newIds[] = $account->id;
                }
            } else {
                unset($accountData['id']); 
                $newAccount = $setting->bankAccounts()->create($accountData);
                $newIds[] = $newAccount->id;
            }
        }

        $toDelete = array_diff($existingIds, $newIds);
        if (count($toDelete) > 0) {
            BankAccount::destroy($toDelete);
        }

        // ✅ DISPARAMOS EL EVENTO DE SWEETALERT2
        $this->dispatch('swal:success', [
            'title' => '¡Guardado con éxito!',
            'text' => 'La configuración de tu tienda se ha actualizado correctamente.'
        ]);
    }
}