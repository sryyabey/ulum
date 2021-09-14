<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslatesTable extends Migration
{
    public function up()
    {
        Schema::create('translates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ayah')->nullable();
            $table->longText('translate')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
