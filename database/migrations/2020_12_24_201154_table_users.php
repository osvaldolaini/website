<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('image',100)->nullable();
            $table->string('update_by',50)->nullable()->after('update_at');
            $table->string('created_by',50)->nullable()->after('created_at');
            /*RELACIONAMENTO*/
            $table->foreign('group_id')->references('id')->on('user_groups')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            /*RELACIONAMENTO*/
            $table->dropForeign('user_groups_id_foreign');
            $table->dropColumn(array('active','group_id','image','update_by'));
        });
    }
}
