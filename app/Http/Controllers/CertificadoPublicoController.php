<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoPublicoController extends Controller
{
    // Mostrar formulario de búsqueda (ahora vacío inicialmente)
    public function index()
    {
        return view('certificados.public-index');
    }

    // Nueva función para búsqueda AJAX
    public function buscarAjax(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:12'
        ]);

        $dni = $request->input('dni');

        // Buscar empleado por DNI
        $empleado = Employee::where('dni', $dni)
            ->where('estado', 'Activo')
            ->first();

        if (!$empleado) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún empleado activo con ese DNI.',
                'html' => $this->getErrorHtml('No se encontró ningún empleado activo con ese DNI.')
            ]);
        }

        // Buscar certificados del empleado
        $certificados = Certificado::where('employee_id', $empleado->id)
            ->where('estado', 'Activo')
            ->orderBy('fecha_emision', 'desc')
            ->get();

        if ($certificados->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron certificados.',
                'html' => $this->getNoResultsHtml($empleado, $dni)
            ]);
        }

        return response()->json([
            'success' => true,
            'empleado' => $empleado,
            'certificados' => $certificados,
            'html' => $this->getResultsHtml($empleado, $certificados, $dni)
        ]);
    }

        // Ver certificado individual
    public function ver($id)
    {
    $certificado = Certificado::with('employee')
        ->where('id', $id)
        ->where('estado', 'Activo')
        ->firstOrFail();

    return view('certificados.public-ver', compact('certificado'));
}

    // Generar HTML para resultados
    private function getResultsHtml($empleado, $certificados, $dni)
    {
        return view('certificados.partials.results', [
            'empleado' => $empleado,
            'certificados' => $certificados,
            'dni' => $dni
        ])->render();
    }

    // Generar HTML para sin resultados
    private function getNoResultsHtml($empleado, $dni)
    {
        return view('certificados.partials.no-results', [
            'empleado' => $empleado,
            'dni' => $dni
        ])->render();
    }

    // Generar HTML para error
    private function getErrorHtml($message)
    {
        return view('certificados.partials.error', [
            'message' => $message
        ])->render();
    }

    // Descargar PDF (se mantiene igual)
    public function descargarPdf($id)
    {
        $certificado = Certificado::with('employee')
            ->where('id', $id)
            ->where('estado', 'Activo')
            ->firstOrFail();

        $pdf = Pdf::loadView('certificados.pdf-publico', [
            'certificado' => $certificado
        ]);

        return $pdf->download('certificado-' . $certificado->numero_certificado . '.pdf');
    }
}