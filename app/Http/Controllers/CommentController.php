<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\TaskComment;
use App\Task;
use App\Status;


class CommentController extends Controller
{
    public function __construct(){
        $this->task = new Task();
        $this->status = new Status();
        $this->comment = new Comment();
    }

    public function index($id){
        $request = [
            'task_id' => $id
        ];
        $request = (object)$request;
        $task = $this->task->getTask($request);
        $status = $this->status->getAllStatus();
//        $comments = $this->comment->getCommentsWithDetails($request);

//        dd($task);

        $data = [
            'task' => $task,
            'status' => $status
        ];
        return view('employee.report')->with('data', $data);
    }

    public function submitReport(Request $request){
        $comment = $this->comment->addComment($request);
        if($comment == true){
            return redirect()->back()->with('success', 'Report Submitted Successfully!');
        } else {
            return redirect()->back()->with('failure', 'Something went wrong. Try again!');
        }
    }
}
