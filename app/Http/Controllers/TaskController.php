<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddTaskRequest;
use App\Projects;
use App\Status;
use App\Task;
use App\ProjectTaskStatus;
use App\User;
use App\UserProjectTasks;

class TaskController extends Controller
{
    function __construct(){
        $this->projects = new Projects();
        $this->status = new Status();
        $this->task = new Task();
        $this->user = new User();
        $this->projectTaskStatus = new ProjectTaskStatus();
        $this->userProjectTask = new UserProjectTasks();
    }

    public function index(){
        $projects = $this->projects->getAllProjectsWithDetail();
        $employee = $this->user->getRole('User');
        $status = $this->status->getAllStatus();
        $tasks = $this->task->getAllTasksWithDetails();

//        dd($test);

        $data = [
            'projects' => $projects,
            'status' => $status,
            'tasks' => $tasks,
            'employees' => $employee
        ];
        return view('tasks.tasks')->with('data', $data);
    }

    public function addTask(AddTaskRequest $request){
//        dd($request->all());
        try{
            if($request->update == 0){
                $result = $this->task->addTask($request);
                return collect([
                    'status' => 'success',
                    'message' => 'Task Created Successfully!'
                ]);
            } else {
                $result = $this->task->updateTask($request);
                return collect([
                    'status' => 'success',
                    'message' => 'Task Updated Successfully!'
                ]);
            }
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function getTask(Request $request){
        try{
            $taskDetail = $this->task->getTask($request);
            $projectID = [
                'project_id' => $taskDetail->projects[0]['id']
            ];
            $projectID = (object)$projectID;
            $projectEmployees = $this->projects->getProjectEmployees($projectID);
//            dd($projectEmployees);
            $data = [
                'projectEmployees' => $projectEmployees,
                'taskDetail' => $taskDetail
            ];
//            return $taskDetail;
            return $data;
        } catch (\Exception $e){
            dd($e);
        }
    }

    public function getTaskAdmin(Request $request){
        try{
            $taskDetail = $this->task->getTaskAdmin($request);
            $projectID = [
                'project_id' => $taskDetail->projects[0]['id']
            ];
            $projectID = (object)$projectID;
            $projectEmployees = $this->projects->getProjectEmployees($projectID);
//            dd($projectEmployees);
            $data = [
                'projectEmployees' => $projectEmployees,
                'taskDetail' => $taskDetail
            ];
//            return $taskDetail;
            return $data;
        } catch (\Exception $e){
            dd($e);
        }
    }

    public function deleteTask(Request $request){
        dd($request->all());
    }

    public function assignTask(){
        $tasks = $this->task->getAllTasksWithDetails();
        $projects = $this->projects->getAllProjectsWithDetail();
        $employees = $this->user->getRole('User');

        $data = [
            'tasks' => $tasks,
            'projects' => $projects,
            'employees' => $employees
        ];
        return view('tasks.assignTask')->with('data', $data);
    }

    public function assignTaskToEmployee(Request $request){
        try {
            $result = $this->userProjectTask->assignTaskToEmployee($request);
            return redirect()->back()->with('success', 'Task have been assigned to selected Employee');
        } catch (\Exception $e){
            return redirect()->back()->with('failure', $e);
        }
    }
}
