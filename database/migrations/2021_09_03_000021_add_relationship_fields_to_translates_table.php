<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTranslatesTable extends Migration
{
    public function up()
    {
        Schema::table('translates', function (Blueprint $table) {
            $table->unsignedBigInteger('lang_id')->nullable();
            $table->foreign('lang_id', 'lang_fk_4793641')->references('id')->on('languages');
            $table->unsignedBigInteger('surah_id')->nullable();
            $table->foreign('surah_id', 'surah_fk_4793644')->references('id')->on('surahs');
        });
    }
}
