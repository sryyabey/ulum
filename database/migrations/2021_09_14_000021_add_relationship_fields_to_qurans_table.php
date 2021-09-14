<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQuransTable extends Migration
{
    public function up()
    {
        Schema::table('qurans', function (Blueprint $table) {
            $table->unsignedBigInteger('surah_id')->nullable();
            $table->foreign('surah_id', 'surah_fk_4793601')->references('id')->on('surahs');
        });
    }
}
