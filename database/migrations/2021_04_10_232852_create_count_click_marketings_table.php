<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountClickMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('count_click_marketings', function (Blueprint $table) {
            $table->id();
            $table->integer('marketing_id')->nullable();
            $table->string('marketing_table')->nullable();
            $table->string('marketing_page')->nullable();
            $table->string('user_device')->nullable();
            $table->string('user_ua')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('count_click_marketings');
    }
}
