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
        Schema::create('commits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('repository_id')->constrained('repositories')->cascadeOnDelete();
            $table->string('sha');
            $table->string('html_url')->nullable();
            $table->text('message')->nullable();
            $table->string('provider_id');
            $table->timestamp('committed_at')->nullable();

            $table->unique(['repository_id', 'sha']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commits');
    }
};
