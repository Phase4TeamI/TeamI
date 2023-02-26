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
        Schema::create('pulls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('repository_id')->constrained('repositories')->cascadeOnDelete();
            $table->integer('number');
            $table->string('html_url')->nullable();
            $table->string('title')->nullable();
            $table->string('provider_id');
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('merged_at')->nullable();
            $table->timestamps();

            $table->unique(['repository_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pulls');
    }
};
