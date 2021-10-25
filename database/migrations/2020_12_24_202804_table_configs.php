<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->string('email')->nullable()->after('slug');
            $table->string('phone')->nullable()->after('email');
            $table->string('cellphone')->nullable()->after('phone');
            $table->string('whatsapp')->nullable()->after('cellphone');
            $table->string('telegram')->nullable()->after('whatsapp');
            $table->string('cnpj')->nullable()->after('telegram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn(array('email','phone','cellphone','whatsapp','telegram','cnpj'));
        });
    }
}
