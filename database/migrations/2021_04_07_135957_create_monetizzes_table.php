<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonetizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('monetizzes', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('link')->nullable();
            $table->string('promotion')->nullable();
            $table->string('path')->nullable();
            $table->text('description')->nullable();
            $table->string('clicks')->nullable();
            /*imagem */
            $table->string('image')->nullable();
            /*Alteração */
            $table->text('updated_because')->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->text('deleted_because')->nullable();
            $table->string('deleted_by')->nullable();
            /*Padrão */
            $table->timestamps();
            $table->string('updated_by',50)->nullable();
            $table->string('created_by',50)->nullable();
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monetizzes');
    }
}
