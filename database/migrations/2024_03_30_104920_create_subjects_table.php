<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('class_id');
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('languag_name');
            $table->timestamps();
        });

        Schema::create('language_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('subject_id');
            $table->timestamps();

            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->primary(['language_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('language_subject');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('languages');
    }
};
