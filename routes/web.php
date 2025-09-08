<?php

use App\Http\Controllers\CertificadoPublicoController;
use Illuminate\Support\Facades\Route;

// Ruta principal (ahora maneja todo)
Route::get('/certificados', [CertificadoPublicoController::class, 'index'])->name('certificados.public');
// Ruta para buscar con AJAX
Route::post('/certificados/buscar-ajax', [CertificadoPublicoController::class, 'buscarAjax'])->name('certificados.buscar.ajax');
// Ruta para descargar PDF
Route::get('/certificados/descargar/{id}', [CertificadoPublicoController::class, 'descargarPdf'])->name('certificados.descargar');

// Ruta para ver certificado individual
Route::get('/certificados/ver/{id}', [CertificadoPublicoController::class, 'ver'])->name('certificados.ver');