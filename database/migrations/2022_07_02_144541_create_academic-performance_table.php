<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicPerformanceTable extends Migration
{
    public function up()
    {
        Schema::create('academic_performances', function (Blueprint $table) {
            $table->primary(['student_id','assignment_id']);
            $table->foreignId('student_id');
            $table->foreignId('assignment_id');
            $table->date('exam_date');
            $table->float('score');
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic-performance');
    }
}
