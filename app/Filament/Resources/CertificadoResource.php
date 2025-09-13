<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificadoResource\Pages;
use App\Filament\Resources\CertificadoResource\RelationManagers;
use App\Models\Certificado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CertificadoResource extends Resource
{
    protected static ?string $model = Certificado::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationLabel = 'Certificados';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Empleado')
                    ->relationship('employee', 'nombre')
                    ->searchable(['nombre', 'dni'])
                    ->preload()
                    ->required(),
                

                
                Forms\Components\Select::make('tipo_certificado')
                    ->label('Tipo de Certificado')
                    ->required()
                    ->options([
                        'Trabajo' => 'Certificado de Trabajo',
                        'Salario' => 'Certificado de Salario',
                        'Tiempo_Servicio' => 'Tiempo de Servicio',
                        'Cargo' => 'Certificado de Cargo',
                        'Personalizado' => 'Certificado Personalizado',
                    ])
                    ->native(false),
                
                /*
                Forms\Components\TextInput::make('numero_certificado')
                    ->label('Número de Certificado')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),  

                Forms\Components\TextInput::make('titulo')
                    ->label('Título del Certificado')
                    ->required()
                    ->maxLength(255),  */
                
                
                Forms\Components\RichEditor::make('contenido')
                ->label('Contenido')
                ->required()
                ->columnSpanFull()
                ->default('Queda constancia de su responsabilidad, compromiso y sobresaliente desempeño en
          el ámbito preprofesional, evidenciando una actitud proactiva, ética y orientada
          al aprendizaje continuo.'),
                


                Forms\Components\DatePicker::make('fecha_emision')
                    ->label('Fecha de Emisión')
                    ->required()
                    ->default(now()),

                Forms\Components\DatePicker::make('fecha_vencimiento')
                    ->label('Fecha de Vencimiento'),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->required()
                    ->options([
                        'Activo' => 'Activo',
                        'Vencido' => 'Vencido',
                        'Anulado' => 'Anulado',
                    ])
                    ->default('Activo')
                    ->native(false),

                                /*
                    Forms\Components\Textarea::make('datos_adicionales')
                        ->label('Datos Adicionales')
                        ->json()
                        ->columnSpanFull(),  

                    Forms\Components\FileUpload::make('firma_digital_path')
                        ->label('Firma Digital')
                        ->directory('certificados/firmas')
                        ->image()
                        ->downloadable()
                        ->default(url('public/firma/firmadaniel.jpg')), // ruta pública de la imagen
                        

                    Forms\Components\FileUpload::make('sello_path')
                        ->label('Sello')
                        ->directory('certificados/sellos')
                        ->image()
                        ->downloadable()
                        ->default(url('/logo/logo horizontal blanco png.png')),  */
                   

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                /*
                Tables\Columns\TextColumn::make('numero_certificado')
                    ->label('Número')
                    ->searchable()
                    ->sortable(), */

                Tables\Columns\TextColumn::make('employee.nombre')
                    ->label('Empleado')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('employee.dni')
                    ->label('DNI')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tipo_certificado')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Trabajo' => 'primary',
                        'Salario' => 'success',
                        'Tiempo_Servicio' => 'info',
                        'Cargo' => 'warning',
                        'Personalizado' => 'gray',
                    }),
                
                /*
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->limit(30),  */

                Tables\Columns\TextColumn::make('fecha_emision')
                    ->label('Emisión')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_vencimiento')
                    ->label('Vencimiento')
                    ->date()
                    ->color(fn ($record) => $record->fecha_vencimiento && $record->fecha_vencimiento->isPast() ? 'danger' : 'success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Activo' => 'success',
                        'Vencido' => 'danger',
                        'Anulado' => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo_certificado')
                    ->label('Tipo de Certificado')
                    ->options([
                        'Trabajo' => 'Trabajo',
                        'Salario' => 'Salario',
                        'Tiempo_Servicio' => 'Tiempo de Servicio',
                        'Cargo' => 'Cargo',
                        'Personalizado' => 'Personalizado',
                    ]),
                    

                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Vencido' => 'Vencido',
                        'Anulado' => 'Anulado',
                    ]),

                Tables\Filters\Filter::make('fecha_emision')
                    ->form([
                        Forms\Components\DatePicker::make('desde'),
                        Forms\Components\DatePicker::make('hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['desde'], fn ($q, $date) => $q->whereDate('fecha_emision', '>=', $date))
                            ->when($data['hasta'], fn ($q, $date) => $q->whereDate('fecha_emision', '<=', $date));
                    }),

                Tables\Filters\Filter::make('certificados_vencidos')
                    ->label('Certificados Vencidos')
                    ->query(fn (Builder $query): Builder => $query->where('estado', 'Vencido')),
            ])
            ->actions([
                Tables\Actions\Action::make('descargarPdf')
                ->label('PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function (Certificado $record) {
                    $pdf = $record->generarPdf();

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        $record->nombre_pdf
                    );
                }),

                

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha_emision', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Relaciones si las necesitamos
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificados::route('/'),
            'create' => Pages\CreateCertificado::route('/create'),
            'edit' => Pages\EditCertificado::route('/{record}/edit'),
        ];
    }
}