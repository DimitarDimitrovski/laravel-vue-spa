<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->string('featured_image');
            $table->json('additional_images')->nullable();
            $table->enum('type', ['sweet', 'salty']);
            $table->enum('preparation_time', ['30', '30-60', '60-120', '120-180', '180']);
            $table->enum('preparation_level', ['easy', 'medium', 'hard']);
            $table->json('ingredients');
            $table->boolean('recommended')->default(0);
            $table->boolean('approved')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
