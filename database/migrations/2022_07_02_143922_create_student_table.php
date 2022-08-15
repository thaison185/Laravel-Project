<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('email',50)->unique();
            $table->string('password',100);
            $table->string('name',30);
            $table->date('DoB');
            $table->string('phone',20);
            $table->boolean('gender');
            $table->string('avatar',100)->nullable();
            $table->boolean('notification')->default(true);
            $table->text('description')->nullable();
            $table->foreignId('class_id');
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student');
    }
}
