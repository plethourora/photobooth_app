<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            // optional user_id: null if guest (but kita akan require login for save)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('filename');     // path to final composed image
            $table->string('thumb_path')->nullable();
            $table->foreignId('frame_id')->nullable()->constrained('frames')->nullOnDelete();
            $table->string('original_filename')->nullable();
            $table->text('caption')->nullable();
            $table->timestamps();
            $table->softDeletes(); // jika ingin enable soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
