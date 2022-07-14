<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorTable extends Migration
{
    public function up()
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->text('description')->nullable();
            $table->foreignId('faculty_id');
            $table->unsignedTinyInteger('degree')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('major');
    }
}
