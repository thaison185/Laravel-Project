<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyTable extends Migration
{

    public function up()
    {
        Schema::create('faculty', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->text('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('department');
    }
}
