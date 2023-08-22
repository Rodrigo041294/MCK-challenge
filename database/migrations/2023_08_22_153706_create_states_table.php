<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('cvegeo');
            $table->string('cve_agee');
            $table->string('nom_agee');
            $table->string('nom_abrev');
            $table->integer('pob');
            $table->integer('pob_fem');
            $table->integer('pob_mas');
            $table->integer('viv');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
