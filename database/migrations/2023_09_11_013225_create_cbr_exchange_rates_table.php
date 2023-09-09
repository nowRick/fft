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
        Schema::create('cbr_exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('num_code');
            $table->string('char_code');
            $table->integer('nominal');
            $table->string('name');
            $table->decimal('value', 22, 14);
            $table->date('date');
            $table->timestamps();

            $table->unique(['char_code', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbr_exchange_rates');
    }
};
