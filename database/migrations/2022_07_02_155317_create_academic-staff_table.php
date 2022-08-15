<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicStaffTable extends Migration
{

    public function up()
    {
        Schema::create('academic_staff', function (Blueprint $table) {
            $table->id();
            $table->string('email',50)->unique();
            $table->string('password',100);
            $table->string('name',30);
            $table->string('avatar',100)->nullable();
            $table->boolean('role');
            $table->boolean('gender');
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_staff');
    }
}
