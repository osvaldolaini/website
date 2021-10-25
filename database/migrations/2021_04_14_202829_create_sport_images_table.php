<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_images', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->boolean('featured')->nullable();
            $table->string('path');
            $table->unsignedBigInteger('sport_id')->nullable();

            /*Padrão */
            $table->timestamps();
            $table->string('updated_by',50)->nullable();
            $table->string('created_by',50)->nullable();

            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sport_images');
    }
}
