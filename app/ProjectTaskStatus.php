<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProjectTaskStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'task_id', 'status_id', 'last_updated_by'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_task_status';

    public function taskDetail()
    {
        return $this->hasOne('App\Task', 'id', 'task_id');
    }

    public function taskStatus(){
        return $this->hasOne('App\Status', 'id', 'status_id');
    }

    public function updateRecord($request){
//        dd($request);
        $record = $this->where('task_id', '=', $request->task_id)->first();
        $array = [
            'project_id' => $request->project_id,
            'task_id' => $request->task_id,
            'status_id' => $request->status_id,
            'last_updated_by' => Auth::user()->id,
        ];
        $result = $record->update($array);
        return $result;
    }


}
