<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CertificadosRelationManager extends RelationManager
{
    protected static string $relationship = 'certificados';

    protected static ?string $title = 'Certificados';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipo_certificado')
                    ->label('Tipo de Certificado')
                    ->required()
                    ->options([
                        'Trabajo' => 'Trabajo',
                        'Salario' => 'Salario',
                        'Tiempo_Servicio' => 'Tiempo de Servicio',
                        'Cargo' => 'Cargo',
                        'Personalizado' => 'Personalizado',
                    ])
                    ->native(false),

                Forms\Components\TextInput::make('numero_certificado')
                    ->label('Número de Certificado')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('titulo')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('contenido')
                    ->label('Contenido')
                    ->required()
                    ->columnSpanFull(),

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

                Forms\Components\Textarea::make('datos_adicionales')
                    ->label('Datos Adicionales (JSON)')
                    ->json()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('firma_digital_path')
                    ->label('Firma Digital')
                    ->directory('certificados/firmas')
                    ->image()
                    ->downloadable(),

                Forms\Components\FileUpload::make('sello_path')
                    ->label('Sello')
                    ->directory('certificados/sellos')
                    ->image()
                    ->downloadable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('titulo')
            ->columns([
                Tables\Columns\TextColumn::make('tipo_certificado')
                    ->label('Tipo')
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('numero_certificado')
                    ->label('Número')
                    ->searchable(),

                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('fecha_emision')
                    ->label('Emisión')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_vencimiento')
                    ->label('Vencimiento')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Activo' => 'success',
                        'Vencido' => 'danger',
                        'Anulado' => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo_certificado')
                    ->label('Tipo')
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
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nuevo Certificado'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}