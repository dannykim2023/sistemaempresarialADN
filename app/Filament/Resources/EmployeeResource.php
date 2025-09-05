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

            Forms\Components\Select::make('estado')
                ->options([
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                    'Licencia' => 'Licencia',
                    'Retirado' => 'Retirado',
                ])
                ->default('Activo'),
                //
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
            //
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
