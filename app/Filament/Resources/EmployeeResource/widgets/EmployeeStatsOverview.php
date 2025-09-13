<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeStatsOverview extends BaseWidget
{
    protected ?string $heading = 'Resumen de Colaboradores';

    protected function getStats(): array
    {
        $activos = Employee::where('estado', 'Activo')->count();
        $inactivos = Employee::where('estado', 'Inactivo')->count();
        $cumplenEsteMes = Employee::whereNotNull('fecha_nacimiento')
            ->whereMonth('fecha_nacimiento', now()->month)
            ->count();

        return [
            Stat::make('Empleados Activos', $activos)
                ->description('Actualmente en servicio')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success')
                // ->getUrl genera la ruta correcta al resource index con parámetros
                ->url(EmployeeResource::getUrl('index', [
                    'tableFilters' => [
                        'estado' => [
                            'value' => 'Activo',
                        ],
                    ],
                ])),

            Stat::make('Empleados Inactivos', $inactivos)
                ->description('Fuera de servicio')
                ->descriptionIcon('heroicon-o-user-minus')
                ->color('danger')
                ->url(EmployeeResource::getUrl('index', [
                    'tableFilters' => [
                        'estado' => [
                            'value' => 'Inactivo',
                        ],
                    ],
                ])),

            Stat::make('Cumpleaños este mes', $cumplenEsteMes)
            ->description('Colaboradores que cumplen este mes')
            ->descriptionIcon('heroicon-o-cake')
            ->color('info')
            ->url(\App\Filament\Resources\EmployeeResource::getUrl('index', [
                'tableFilters' => [
                    'cumple_mes' => [
                        'value' => true,
                        'isActive' => true, // 👈 forzar que esté activo
                    ],
                ],
            ])),

        ];
    }
}
