<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMealContentsTable extends Migration
{
    public function up()
    {
        Schema::table('meal_contents', function (Blueprint $table) {
            $table->unsignedBigInteger('meal_id')->nullable();
            $table->foreign('meal_id', 'meal_fk_4873027')->references('id')->on('meals');
            $table->unsignedBigInteger('surah_id')->nullable();
            $table->foreign('surah_id', 'surah_fk_4873030')->references('id')->on('surahs');
        });
    }
}
