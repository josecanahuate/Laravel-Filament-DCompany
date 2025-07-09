<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//day_in, day_out, debieron colocarse en nullable, por el momento se uso un string vacio ''. sqllite no permite alterar tablas.

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendar_id');
            $table->foreignId('user_id');
            $table->enum('type', ['work', 'pause'])->default('work');
            $table->timestamp('day_in'); //debio colocarse en nullable
            $table->timestamp('day_out'); //debio colocarse en nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
