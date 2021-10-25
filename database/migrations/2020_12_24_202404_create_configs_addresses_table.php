<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('config_id')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('complement')->nullable();
            $table->timestamps();
            /*RELACIONAMENTO*/
            $table->foreign('config_id')->references('id')->on('configs')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs_addresses');
    }
}
