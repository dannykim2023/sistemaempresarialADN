<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Colaboradores';
    protected static ?string $navigationGroup = 'Gestión de Personal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('avatar_path')
                ->label('Foto')
                ->disk('public')
                ->image()
                ->directory('avatars')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(200),

            Forms\Components\TextInput::make('dni')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('email')
                ->email()
                ->nullable(),

            Forms\Components\TextInput::make('telefono')->nullable(),

            Forms\Components\TextInput::make('direccion')->nullable(),

            Forms\Components\DatePicker::make('fecha_nacimiento'),

            Forms\Components\KeyValue::make('contacto_emergencia')
                ->label('Contacto de emergencia')
                ->keyLabel('Campo')
                ->valueLabel('Dato')
                ->default([
                    'nombre' => '',
                    'relacion' => '',
                    'numero' => '',
                ])
                ->nullable(),

            Forms\Components\Select::make('area')
                ->options([
                    'Diseño Web' => 'Diseño web',
                    'Creativos' => 'Creativos',
                    'Tecnología' => 'Tecnología',
                    'Administración' => 'Administración',
                    'Talento Humano' => 'Talento Humano',
                    'Recursos Humanos' => 'Recursos Humanos',
                ]),

            Forms\Components\Select::make('estado')
                ->options([
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                    'Licencia' => 'Licencia',
                    'Retirado' => 'Retirado',
                ])
                ->default('Activo'),

                 // ────────── CAMPOS DE CONTRATO ──────────
                Forms\Components\Select::make('tipo_contrato')
                    ->label('Tipo de contrato')
                    ->options([
                        'Indefinido' => 'Indefinido',
                        'Plazo fijo' => 'Plazo fijo',
                        'Servicios' => 'Servicios',
                        'Prácticas' => 'Prácticas',
                        'Temporal' => 'Temporal',
                    ])
                    ->default('Servicios'),

                Forms\Components\TextInput::make('salario')
                    ->label('Salario')
                    ->numeric(),
                    //->nullable(),

                Forms\Components\Select::make('jornada')
                    ->label('Jornada')
                    ->options([
                        'Tiempo completo' => 'Tiempo completo',
                        'Medio tiempo' => 'Medio tiempo',
                        'Por horas' => 'Por horas',
                    ])
                    ->default('Tiempo completo'),

                Forms\Components\DatePicker::make('fecha_inicio')
                    ->label('Fecha de inicio')
                    ->nullable(),

                Forms\Components\DatePicker::make('fecha_fin')
                    ->label('Fecha de fin')
                    ->nullable(),

                // Forms\Components\FileUpload::make('documento_path')
                //     ->label('Documento del contrato')
                //     ->directory('contracts')
                //     ->disk('public')
                //     ->nullable(),


                
            ]);
    }

    public static function table(Table $table): Table
    {
            return $table->columns([
            Tables\Columns\ImageColumn::make('avatar_path')->label('Foto')->circular(),
            Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('dni'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('telefono'),
            Tables\Columns\TextColumn::make('estado')->badge(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i'),
            // ────────── CAMPOS DE CONTRATO ──────────
            Tables\Columns\TextColumn::make('tipo_contrato')
                ->label('Tipo de contrato')
                ->sortable(),

            Tables\Columns\TextColumn::make('jornada')
                ->label('Jornada')
                ->sortable(),
                
            Tables\Columns\TextColumn::make('area')
                ->label('Area')
                ->sortable()
                ->badge(),
                
            Tables\Columns\TextColumn::make('salario')
            ->label('Salario')
            ->sortable()
            ->formatStateUsing(fn ($state) => $state !== null ? 'S/'.number_format($state, 2) : '-'),



            Tables\Columns\TextColumn::make('fecha_inicio')
                ->label('Inicio')
                ->date('d/m/Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('fecha_fin')
                ->label('Fin')
                ->date('d/m/Y')
                ->sortable(),

            // Tables\Columns\TextColumn::make('documento_path') // Comentado por ahora
            //     ->label('Documento'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // ✅ Agregar esta línea para relacionar
            \App\Filament\Resources\EmployeeResource\RelationManagers\CertificadosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
