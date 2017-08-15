<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddProjectRequest;
use App\Projects;
use App\Organization;
use App\User;

class ProjectController extends Controller
{
    function __construct()
    {
        $this->organizations = new Organization();
        $this->projects = new Projects();
        $this->user = new User();
    }

    public function index(){
        $org = $this->organizations->getAllOrganizations();
//        $projects = $this->projects->getALLProjects();
        $projects = $this->projects->getAllProjectsWithDetail();
        $data = [
            'org' => $org,
            'projects' => $projects
        ];
        return view('projects.projects')->with('data', $data);
    }

    public function addProject(AddProjectRequest $request){
//        dd($request->all());
        if($request->update == 0){
            $result = $this->projects->addProject($request);
            return collect([
                'status' => 'success',
                'message' => 'Project added successfully!'
            ]);
        } else {
            $result = $this->projects->updateProject($request);
            return collect([
                'status' => 'success',
                'message' => 'Project added successfully!'
            ]);
        }

    }

    public function deleteProject(Request $request){
        try{
            $result = $this->projects->deleteProject($request);
            if($result == true){
                return 1;
            } else {
                return 0;
            }
        } catch(\Exception $e){
            dd($e);
        }
    }

    public function getProject(Request $request){
        try{
            $project = $this->projects->getProject($request);
            $projectOrg = $this->projects->getProjectOrganization($project);
            $data = [
                'project' => $project,
                'projectOrg' => $projectOrg
            ];
            return $data;
        } catch(\Exception $e){
            dd($e);
        }
    }

    public function assignProject(){
        $projects = $this->projects->getALLProjects();
        $employees = $this->user->getRole('User');

        $data = [
            'projects' => $projects,
            'employees' => $employees
        ];
        return view('projects.assignProject')->with('data', $data);
    }

    public function assignProjectToEmployees(Request $request){
        $result = $this->projects->assignProjectToEmployees($request);
//        dd($result);
        return redirect()->back()->with('success', 'Projects have been assigned to selected Employees');
    }

    public function getProjectEmployees(Request $request){
        try {
            $result = $this->projects->getProjectEmployees($request);
            return $result;
        } catch (\Exception $e){
            dd($e);
        }
    }

    public function getProjectsWithDetail(){
        return $this->projects->getAllProjectsWithDetail();
    }

    public function getProjectTasks(Request $request){
        $projectTasks = $this->projects->getProjectTasks($request);
        return $projectTasks;
    }

    public function viewProject($id){
        $data = [
            'project_id' => $id
        ];
        $data = (object)$data;

        $projectTasks = $this->projects->getProjectTasks($data);
        $projectDesc = [
            'project' => json_decode($projectTasks)
        ];
        return view('projects.projectDetail')->with('data', json_decode($projectTasks));
    }
}
