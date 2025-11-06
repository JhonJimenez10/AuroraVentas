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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Tipo de Identificacion (RUC o CEDULA)
            $table->enum('id_type', ['RUC', 'CEDULA']);

            // Identificacion (número del documento)
            $table->string('identification', 25);

            // Nombre completo
            $table->string('full_name', 150);

            // Teléfono (opcional; si quieres forzar único, agrega ->unique())
            $table->string('phone', 30)->nullable();

            // Correo
            $table->string('email', 150)->nullable();

            // Código Postal
            $table->string('postal_code', 20)->nullable();

            // Ciudad / Cantón / Provincia
            $table->string('city', 100)->nullable();
            $table->string('canton', 100)->nullable();
            $table->string('province', 100)->nullable();

            // Dirección
            $table->string('address', 255)->nullable();

            $table->timestamps();

            // Unicidad combinada de tipo+identificación
            $table->unique(['id_type', 'identification']);

            // Índices útiles
            $table->index('full_name');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
