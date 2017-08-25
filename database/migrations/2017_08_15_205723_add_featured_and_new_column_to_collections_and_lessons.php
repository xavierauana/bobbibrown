<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturedAndNewColumnToCollectionsAndLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('collections', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
        });
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
