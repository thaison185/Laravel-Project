<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicPerformanceTable extends Migration
{
    public function up()
    {
        Schema::create('academic_performances', function (Blueprint $table) {
            $table->foreignId('student_id');
            $table->foreignId('subject_id');
            $table->foreignId('lecturer_id');
            $table->float('score');
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic-performance');
    }
}
