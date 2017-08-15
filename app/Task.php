<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectTaskStatus;
use App\UserProjectTasks;
use App\Comment;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_title', 'task_desc'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * Get Total Tasks.
     *
     * @var int
     */
    public function getTotalTasks(){
        return $count = $this->count();
    }

    public function projects(){
        return $this->belongsToMany('App\Projects', 'project_task_status',  'task_id', 'project_id');
    }

    public function status(){
        return $this->belongsToMany('App\Status', 'project_task_status', 'task_id', 'status_id');
    }

    public function employees(){
        return $this->belongsToMany('App\User', 'user_project_tasks', 'task_id', 'user_id');
    }

    public function comments(){
        return $this->belongsToMany('APP\Comment', 'task_comments', 'task_id', 'comment_id')->orderBy('id', 'desc');
    }

    public function getAllTasks(){
        return $this->get();
    }

    public function getAllTasksWithDetails(){
        return $this->with('projects', 'status', 'employees')->get();
    }

    public function addTask($request){
        $array = [
            'task_title' => $request->task_title,
            'task_desc' => $request->task_desc,
        ];
        $task = $this->create($array);
        $arr = [
            'project_id' => $request->task_project,
            'task_id' => $task->id,
            'status_id' => $request->task_status,
            'last_updated_by' => \Auth::user()->id,
        ];
        $projTaskStatus = ProjectTaskStatus::create($arr);
        $userProjTask = [
            'employees' => $request->task_employee,
            'projects' => $request->task_project,
            'tasks' => $task->id
        ];

        $userProjTask = (object)$userProjTask;

        $obj = new UserProjectTasks();
        $result = $obj->assignTaskToEmployee($userProjTask);

        return $result;
    }

    public function updateTask($request){
        $array = [
            'task_title' => $request->task_title,
            'task_desc' => $request->task_desc,
        ];
        $task = $this->find($request->task_id);
        $task->update($array);

        $arr = [
            'project_id' => $request->task_project,
            'task_id' => $request->task_id,
            'status_id' => $request->task_status,
            'last_updated_by' => \Auth::user()->id,
        ];
        $projectTaskStatus = ProjectTaskStatus::where('task_id', '=', $request->task_id)->first();
        $result1 = $projectTaskStatus->update($arr);

        $userProjTask = [
            'employees' => $request->task_employee,
            'projects' => $request->task_project,
            'tasks' => $request->task_id
        ];

        $userProjTask = (object)$userProjTask;

        $obj = new UserProjectTasks();
        $result = $obj->updateUserProjectTask($userProjTask);

        return $result;
    }

    public function getTask($request){
        return $this->with('projects', 'status', 'employees', 'comments.user')->where('id', '=', $request->task_id)->first();
    }

    public function getTaskAdmin($request){
        return $this->with('projects', 'status', 'employees')->where('id', '=', $request->task_id)->first();
    }


}
