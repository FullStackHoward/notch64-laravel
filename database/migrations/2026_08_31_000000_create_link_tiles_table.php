<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_tiles', function (Blueprint $table) {
            $table->id();
            $table->string('section')->index(); // main | community | social
            $table->string('title')->nullable();
            $table->string('url');
            $table->string('image_path')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('bg_position')->nullable();
            $table->string('bg_size')->nullable();

            /*
             * Mobile overrides are nullable on purpose: when null the desktop
             * value cascades through a CSS var fallback. Only tiles whose
             * artwork needs a different crop on a phone set these.
             */
            $table->string('bg_position_mobile')->nullable();
            $table->string('bg_size_mobile')->nullable();

            $table->boolean('open_in_new_tab')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_tiles');
    }
};
