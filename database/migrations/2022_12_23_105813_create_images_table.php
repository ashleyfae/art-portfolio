<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('alt_text')->nullable();
            $table->text('image_path');
            $table->unsignedBigInteger('width')->nullable()->default(null);
            $table->unsignedBigInteger('height')->nullable()->default(null);
            $table->unsignedBigInteger('bytes')->nullable()->default(null);
            $table->text('mime')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('artwork_image', function(Blueprint $table) {
            $table->foreignIdFor(\App\Models\Artwork::class);
            $table->foreignIdFor(\App\Models\Image::class);
            $table->boolean('is_primary')->default(false);

            $table->unique(['artwork_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('artwork_image');
    }
};
