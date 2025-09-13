<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use App\Models\Employee;
use Filament\Tables;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class LeadersTable extends TableWidget
{
    public function getTableQuery(): Builder|Relation|null
    {
        return Employee::query()->where('puesto', 'like', '%Lider%');
    }

    protected function getTableColumns(): array
    {
        return [
        Tables\Columns\ImageColumn::make('avatar_path')
            ->label('Foto')
            ->rounded()
            ->square(50), // tamaño de la imagen
        Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
        Tables\Columns\TextColumn::make('area')->label('Área'),
        Tables\Columns\TextColumn::make('puesto')->label('Puesto'),
        Tables\Columns\TextColumn::make('telefono')->label('Número'),
    ];
    }
}
