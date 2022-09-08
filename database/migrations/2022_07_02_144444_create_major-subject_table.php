<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorSubjectTable extends Migration
{
    public function up()
    {
        Schema::create('major-subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id');
            $table->foreignId('subject_id');
            $table->unsignedTinyInteger('semester');
            $table->integer('lecture_hour');
            $table->unique(['major_id','subject_id','semester']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('major-subject');
    }
}
