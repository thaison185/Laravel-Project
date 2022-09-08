<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerSubjectClassTable extends Migration
{
    public function up()
    {
        Schema::create('lecturer-subject-class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id');
            $table->foreignId('major-subject_id');
            $table->foreignId('lecturer_id');
            $table->unique(['class_id','major-subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecturer-subject-class');
    }
}
