<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // this will reference the book table, this column is a foreign key
            // foreign key is a column in a database table that refers to the primary key of another table.Now this would enforce the so called referential integrity, which ensures that a record in one table has a coresponding record in another table, which measn that if we put a value to this column book_id and lets say that would be 5 we make sure that another row inside this books table exists and has the id 5
            // $table->unsignedBigInteger('book_id');

            $table->text('review');
            $table->unsignedTinyInteger('rating');
            $table->timestamps();

            // to define a foreign key we use foreign() and also call another method references(),this will specify what column on the other table this foreign key references,and it references id on the other books table.You also need on method to specify table and additionally we will add on delete handler specifying it to be cascade and what this does is it specifies that when the book record would be deleted from the database all related reviews should be removed too
            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

            // now in modern laravel version you can simply by using this syntax
            // this constraint method will automatically set up foreign key constraint which means referential integrity
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};