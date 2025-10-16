<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('created_by');
            $table->string('address');
            $table->decimal('lat', 10, 8); // -90.00000000 a 90.00000000
            $table->decimal('lng', 11, 8); // -180.00000000 a 180.00000000
            $table->enum('state', ['RESERVED', 'SCHEDULED', 'INSTALLED', 'UNINSTALLED', 'CANCELED'])
                  ->default('RESERVED');
            $table->timestamps();
            
            // Índices para mejorar búsquedas
            $table->index('state');
            $table->index('created_by');
            $table->index(['lat', 'lng']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};