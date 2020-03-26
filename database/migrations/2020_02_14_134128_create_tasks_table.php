<?php

use App\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('name');
            $table->text('description');
            $table->dateTime('expire_date')->nullable();
            $table->unsignedInteger('hours_spent')->nullable();
            $table->decimal('task_cost', 5,2)->default(0)->nullable();

            $table->enum('status',Task::TASK_STATUS);
            $table->enum('priority',Task::TASK_PRIORITY);

            $table->boolean('is_done')->default(false);

            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
