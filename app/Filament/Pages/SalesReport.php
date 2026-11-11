<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables;
use App\Models\Order;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesReport extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string $view = 'filament.pages.sales-report';
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Reporte de Ventas';
    protected static ?string $title = 'Generador de Reportes';
    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->check(); 
    }

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
            'end_date' => Carbon::now()->format('Y-m-d'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filtrar Reporte')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Desde')
                            ->required()
                            ->live(),
                        DatePicker::make('end_date')
                            ->label('Hasta')
                            ->required()
                            ->live(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        // Validación para evitar errores si las fechas están vacías
        $startDate = $this->data['start_date'] ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $this->data['end_date'] ?? now()->format('Y-m-d');

        return $table
            ->query(
                Order::query()
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Nro. Pedido'),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->default(fn ($record) => $record->user->name ?? 'Consumidor Final'),
                Tables\Columns\TextColumn::make('sale_type')
                    ->label('Canal')
                    ->badge(),
                Tables\Columns\TextColumn::make('total')->label('Total')->money('USD'),
                Tables\Columns\TextColumn::make('status')->label('Estado')->badge(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')->dateTime('d/m/Y h:i A'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_pdf')
                    ->label('Descargar PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('danger')
                    ->action(function () use ($startDate, $endDate) {
                        $orders = Order::whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate)
                            ->get();
                        
                        $totalVentas = $orders->sum('total');

                        $pdf = Pdf::loadView('reports.sales-pdf', [
                            'orders' => $orders,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'totalVentas' => $totalVentas
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, 'Reporte_Ventas_SubliArte.pdf');
                    }),
            ]);
    }
}