<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBoardingRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boarding_rooms', function (Blueprint $table) {
            $table->foreign('boarding_house_id', 'boarding_house_id_fk1')->references('id')
                ->on('boarding_houses')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boarding_rooms', function (Blueprint $table) {
            $table->dropForeign('boarding_house_id_fk1');
        });
    }
}
