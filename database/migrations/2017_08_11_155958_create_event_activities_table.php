<?php

use App\Enums\EventActivityTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $reflectionClass = new ReflectionClass(EventActivityTypes::class);
        $eumns = array_values($reflectionClass->getConstants());

        Schema::create('event_activities', function (Blueprint $table) use ($eumns) {
            $table->increments('id');
            $table->enum('type', $eumns);
            $table->string('ip');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('token')->nullable();

            // Relation
            $table->integer('event_id')->unsigned();
            $table->foreign("event_id")->references('id')->on("events")->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign("user_id")->references('id')->on("users")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('event_activities');
    }
}
