<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('supplier_id')->unique();
            $table->foreignId('mark_id')->constrained('marks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('model_id')->constrained('models')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('year_id')->constrained('years')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('run_id')->constrained('runs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained('colors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('body_type_id')->constrained('body_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('engine_type_id')->constrained('engine_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('transmission_id')->constrained('transmissions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('gear_type_id')->constrained('gear_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('generation_id')->nullable()->constrained('generations')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

            $table->index('mark_id');
            $table->index('model_id');
            $table->index('year_id');
            $table->index('run_id');
            $table->index('color_id');
            $table->index('body_type_id');
            $table->index('engine_type_id');
            $table->index('transmission_id');
            $table->index('gear_type_id');
            $table->index('generation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogs');
    }
};
