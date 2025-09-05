<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // Datos personales
            $table->string('nombre', 200);
            $table->string('dni', 12)->unique();
            $table->string('email', 150)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('direccion', 250)->nullable();
            $table->date('fecha_nacimiento')->nullable();

            // Contacto de emergencia (guardado como JSON)
            // Ejemplo: { "nombre": "Juan Pérez", "telefono": "999999999", "relacion": "Hermano" }
            $table->json('contacto_emergencia')->nullable();

            // Imagen de perfil (ruta al archivo subido)
            $table->string('avatar_path', 255)->nullable();

            // Estado laboral
            $table->enum('estado', ['Activo', 'Inactivo', 'Licencia', 'Retirado'])
                  ->default('Activo');

            // Control de auditoría (quién creó / actualizó)
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps(); // created_at y updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
