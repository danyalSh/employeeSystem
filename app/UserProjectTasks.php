<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProjectTasks extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'project_id', 'task_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_project_tasks';

    public function assignTaskToEmployee($request){
//        dd($request);
        $array = [
            'user_id' => $request->employees,
            'project_id' => $request->projects,
            'task_id' => $request->tasks
        ];
        $result = $this->create($array);
        return $result;
    }

    public function updateUserProjectTask($request){
        $record = $this->where('task_id', '=', $request->tasks)->first();
        $array = [
            'user_id' => $request->employees,
            'project_id' => $request->projects,
            'task_id' => $request->tasks
        ];
        $result = $record->update($array);
        return $result;
    }
}
