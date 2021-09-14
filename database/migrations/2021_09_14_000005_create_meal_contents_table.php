<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealContentsTable extends Migration
{
    public function up()
    {
        Schema::create('meal_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('content')->nullable();
            $table->string('ayah')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
