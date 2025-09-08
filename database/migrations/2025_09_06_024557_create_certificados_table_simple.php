<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // ✅ SOLO la columna, SIN foreign key
            $table->enum('tipo_certificado', ['Trabajo', 'Salario', 'Tiempo_Servicio', 'Cargo', 'Personalizado']);
            $table->string('numero_certificado', 50);
            $table->string('titulo', 255);
            $table->text('contenido');
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('estado', ['Activo', 'Vencido', 'Anulado'])->default('Activo');
            $table->string('template', 255)->nullable();
            $table->json('datos_adicionales')->nullable();
            $table->string('firma_digital_path', 255)->nullable();
            $table->string('sello_path', 255)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique('numero_certificado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};