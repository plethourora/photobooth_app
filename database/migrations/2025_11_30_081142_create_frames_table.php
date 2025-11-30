<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFramesTable extends Migration
{
    public function up()
    {
        Schema::create('frames', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // simpan path relatif di storage (public)
            $table->string('image_path');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frames');
    }
}
