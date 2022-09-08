<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerSubjectClassTable extends Migration
{
    public function up()
    {
        Schema::create('lecturer-subject-class', function (Blueprint $table) {
            $table->foreignId('lecturer_id');
            $table->foreignId('subject_id');
            $table->foreignId('class_id');
            $table->unsignedTinyInteger('semester');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecturer-subject-class');
    }
}
