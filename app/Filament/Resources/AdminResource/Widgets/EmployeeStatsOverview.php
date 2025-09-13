<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class EmployeeStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Colaboradores Activos', Employee::where('estado', 'Activo')->count())
                ->color('success') // Verde
                ->description('Total'),

            Card::make('Salidas este mes', Employee::where('estado', 'Retirado')
                ->whereMonth('fecha_fin', now()->month)
                ->count())
                ->color('danger') // Rojo
                ->description('Cantidad'),

            Card::make('Diseño Web', Employee::where('area', 'Diseño Web')->count())
                ->color('primary') // Azul
                ->description('Cantidad'),

            Card::make('Creativos', Employee::where('area', 'Creativos')->count())
                ->color('secondary') // Gris
                ->description('Cantidad'),

            Card::make('Talento Humano', Employee::where('area', 'Talento Humano')->count())
                ->color('info') // Azul claro
                ->description('Cantidad'),

            Card::make('Community Manager', Employee::where('puesto', 'Community Manager')->count())
                ->color('warning') // Ámbar
                ->description('Cantidad'),
        ];
    }
}
