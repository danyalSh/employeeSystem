<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Organization;
use App\Projects;
use App\User;
use App\Task;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->organization = new Organization();
        $this->project = new Projects();
        $this->user = new User();
        $this->task = new Task();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
            if(Auth::user()->hasRole('User')){
                $result = $this->user->getUserProjects();
                return view('employee.dashboard')->with('data', $result);
            } else {
                $data = [
                    'organizations' => $this->organization->getTotalOrganization(),
                    'projects' => $this->project->getTotalProjects(),
                    'users' => $this->user->getTotalUsers(),
                    'tasks' => $this->task->getTotalTasks(),
                ];

                return view('admin/dashboard', $data);
            }


        } else {
            return redirect('/login');
        }
    }
}
