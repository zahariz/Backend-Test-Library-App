<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowed_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("book_id")->nullable(false);
            $table->unsignedBigInteger("member_id")->nullable(false);
            $table->dateTime('borrowed_at');
            $table->dateTime('returned_at')->nullable(true);
            $table->timestamps();

            $table->foreign("book_id")->on("books")->references("id");
            $table->foreign("member_id")->on("members")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_books');
    }
};
