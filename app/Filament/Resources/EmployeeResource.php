<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;


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
    protected static ?string $navigationGroup = 'Administración';

    // widget empleados
    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatsOverview::class,
        ];
    }



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
                ->label('Nombre y Apellido') 
                ->required()
                ->maxLength(200),

            Forms\Components\TextInput::make('dni')
                ->required()
                ->unique(ignoreRecord: true)
                ->length(8)
                ->reactive()
                ->afterStateUpdated(function ($state, $set) {
                    if (strlen($state) === 8) {
                        $api = new \App\Services\ApiDniService();
                        $data = $api->consultarDni($state);

                        if ($data && isset($data['full_name'])) {
                            $set('nombre', $data['full_name']); // 👈 Usa el campo correcto
                        } else {
                            $set('nombre', null);
                        }
                    }
                }),



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
                
                ->label("Departamento")
                ->options([
                    'Diseño Web' => 'Diseño web',
                    'Creativos' => 'Creativos',
                    'Tecnología' => 'Tecnología',
                    'Administración' => 'Administración',
                    'Talento Humano' => 'Talento Humano',
                    'Recursos Humanos' => 'Recursos Humanos',
                    'Comercial' => 'Comercial',
                ]),

            Forms\Components\Select::make('puesto')
                ->label("Puesto")
                ->options([
                    // Puestos base
                    'Diseñador Web' => 'Diseñador Web',
                    'Desarrollador SEO' => 'Desarrollador SEO',
                    'Diseñador Gráfico' => 'Diseñador Gráfico',
                    'Community Manager' => 'Community Manager',
                    //'Ejecutivo de Ventas' => 'Ejecutivo de Ventas',
                    'Asistente Administrativo' => 'Asistente Administrativo',
                    'Contador' => 'Contador',
                    'Soporte Técnico' => 'Soporte Técnico',
                    'Reclutamiento y capacitacion' => 'Reclutamiento y capacitacion',
                    'Atención al Cliente' => 'Atención al Cliente',
                    'Gerente General' => 'Gerente General',
                    //'Jefe de Operaciones' => 'Jefe de Operaciones',
                    //'Marketing Digital' => 'Marketing Digital',

                    // Puestos líderes
                    'Líder Tecnología' => 'Líder Tecnología',
                    'Líder Diseño Web' => 'Líder Diseño Web',
                    'Líder Diseño Gráfico' => 'Líder Diseño Gráfico',
                    'Líder Creativos' => 'Líder Creativos',
                    'Líder Ventas' => 'Líder Ventas',
                    'Líder SEO' => 'Líder SEO',
                    'Líder Soporte' => 'Líder Soporte',
                ]),


            Forms\Components\Select::make('estado')
                ->options([
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                    'Permiso' => 'Permiso',
                    'Retirado' => 'Retirado',
                ])
                ->default('Activo'),

                 // ────────── CAMPOS DE CONTRATO ──────────
                Forms\Components\Select::make('tipo_contrato')
                    ->label('Tipo de contrato')
                    ->options([
                        'Practicas profesionales' => 'Practicas profesionales',
                        'Practicas pre profesionales' => 'Practicas pre profesionales',
                        'Locador de Servicios' => 'Locador de Servicios',
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
                        'Turno temprano' => 'Turno temprano',
                        'Turno tarde' => 'Turno tarde',
                        'Tiempo completo' => 'Tiempo completo',
                        'Sin horario' => 'Sin horario',
                    
                    ])
                    ->default('Tiempo completo'),

                Forms\Components\DatePicker::make('fecha_inicio')
                    ->label('Fecha de inicio')
                    ->nullable(),

                Forms\Components\DatePicker::make('fecha_fin')
                    ->label('Fecha de fin')
                    ->nullable(),

                Forms\Components\FileUpload::make('documento_path')
                     ->label('Cv Curriculum')
                     ->directory('curriculumns')
                     ->disk('public')
                     ->nullable(),


                
            ]);
    }

    public static function table(Table $table): Table
    {
            
            return $table
            ->defaultSort('created_at', 'desc') // ordena por últimos añadidos
            ->columns([
            Tables\Columns\ImageColumn::make('avatar_path')->label('Foto')->circular(),
            Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('dni'),
            Tables\Columns\TextColumn::make('area'),
            Tables\Columns\TextColumn::make('puesto'),
            Tables\Columns\TextColumn::make('telefono'),
            Tables\Columns\TextColumn::make('estado')->badge(),
            //Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i'),

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
                // Filtro por estado
                SelectFilter::make('estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Inactivo' => 'Inactivo',
                        'Licencia' => 'Licencia',
                        'Retirado' => 'Retirado',
                    ]),

                
                // Filtro que se activa/desactiva (checkbox/toggle)
                Filter::make('cumple_mes')
                    ->label('Cumpleaños este mes')
                    ->toggle() // muestra toggle en la UI (opcional)
                    ->query(function (Builder $query, array $data = []) : Builder {
                        // Nota: la query se aplica cuando el filtro se considera activo.
                        // Como a veces Filament manda ['value' => true] desde URL, usar whereMonth directo.
                        return $query->whereNotNull('fecha_nacimiento')
                            ->whereMonth('fecha_nacimiento', now()->month);
                    }), // 👈 importante: permite activarlo/desactivarlo desde URL

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()
                
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
