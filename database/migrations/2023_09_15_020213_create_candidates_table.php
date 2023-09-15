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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('source');
            $table->unsignedBigInteger('owner')->nullable();
            $table->foreign('owner')->references('id')->on('users')->onDelete('set null'); // It's possible to do softDelets here
            $table->timestamp('created_at');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null'); // It's possible to do softDelets here
            $table->timestamp('updated_at'); // Eloquent expect this column default
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
};
