<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerTable extends Migration
{
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('email',50)->unique();
            $table->string('password',100);
            $table->string('name',30);
            $table->date('DoB');
            $table->boolean('gender');
            $table->string('avatar',100)->nullable();
            $table->string('title',15)->nullable();
            $table->text('degree')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('faculty_id');
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecturer');
    }
}
