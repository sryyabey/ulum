<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurahsTable extends Migration
{
    public function up()
    {
        Schema::create('surahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('arabic')->nullable();
            $table->string('latin')->nullable();
            $table->string('sajda')->nullable();
            $table->integer('ayah')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
