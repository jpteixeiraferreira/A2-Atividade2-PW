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
        Schema::create('historico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('acao');
            $table->string('tipo');
            $table->integer('quantidade')->default(0);
            $table->decimal('preco_unitario', 15, 2)->default(0);
            $table->decimal('valor_total', 15, 2)->default(0);
            $table->timestamp('data_operacao')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico');
    }
};
