<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorSubjectTable extends Migration
{
    public function up()
    {
        Schema::create('major-subject', function (Blueprint $table) {
            $table->foreignId('major_id');
            $table->foreignId('subject_id');
            $table->unsignedTinyInteger('semester');
        });
    }

    public function down()
    {
        Schema::dropIfExists('major-subject');
    }
}
