<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
			$table->foreignId('project_id')->constrained('projects', 'id')->onDelete('cascade');
			$table->nullableMorphs('subject');
			$table->string('description');
			$table->text('changes')->nullable();
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
        Schema::dropIfExists('activities');
    }
};
