<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTable extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->string('admission_year',4);
            $table->foreignId('major_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('class');
    }
}
