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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('entry_id')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('municipality')->nullable();
            $table->string('barangay')->nullable();
            $table->boolean('honors_received')->nullable()->default(false);
            // if in school
            $table->string('employment')->nullable();
            // in not in school
            $table->string('status')->nullable();
            $table->string('college_course')->nullable();
            $table->string('vocational')->nullable();
            $table->string('others')->nullable();
            // remarks
            $table->string('remarks')->nullable();  
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
