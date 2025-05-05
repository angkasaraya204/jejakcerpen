<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained();
            $table->boolean('anonymous')->default(false);
            $table->boolean('is_sensitive')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stories');
    }
};
