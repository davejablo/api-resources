<?php

use App\Task;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    private $workers;
    private $current;
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function __construct()
    {
        $this->workers = User::select('id', 'project_id')
            ->join('role_user', function ($join) {
            $join->on('users.id', '=', 'role_user.user_id')
                ->where('role_user.role_id', '=', 3);
            })
            ->get();

        $this->current = null;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::truncate();
        foreach ($this->workers as $worker){
            $this->current = $worker;
            factory(App\Task::class, rand(1,4))->create()->each(function ($task) {
                $task->project()->associate($this->current->project_id);
                $task->user()->associate($this->current->id);
                $task->save();
            });}

        DB::table('tasks')
            ->where('status', 'not_assigned')
            ->update(['user_id' => null]);
    }
}
