<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectTaskStatus;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'user_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    public function task(){
        return $this->belongsToMany('App\Task', 'task_comments', 'comment_id', 'task_id');
    }

//    public function user(){
//        return $this->belongsToMany('App\Task', 'user_comments', 'comment_id', 'user_id');
//    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function addComment($request){
        //dd($request->all());
        $comment = [
            'comment' => $request->comment,
            'user_id' => Auth::user()->id
        ];
        $result = $this->create($comment);
        $task_comment = $result->task()->attach($request->task_id);

        $obj = new ProjectTaskStatus();
        $pts = $obj->updateRecord($request);
        return $pts;
    }

    public function getCommentsWithDetails($request){
        return $this->with('task.comments', 'user')->get();
    }
}
