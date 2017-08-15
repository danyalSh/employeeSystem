<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_title', 'project_desc'
    ];

    /**
     * Get Total Projects.
     *
     * @var int
     */
    public function getTotalProjects(){
        return $count = $this->count();
    }

    public function organization(){
        return $this->belongsToMany('App\Organization', 'organization_projects', 'project_id', 'organization_id');
    }

    public function user(){
        return $this->belongsToMany('App\User', 'user_projects', 'project_id', 'user_id')->withTimestamps();
    }

    public function addProject($request){
//        dd($this->organization());
        $array = [
            'project_title' => $request->project_title,
            'project_desc' => $request->project_desc,
        ];
        $project = $this->create($array);
        $org = $request->project_org;
        $this->assignOrg($project, $org);
        return $project->id;

    }

    public function updateProject($request){
//        dd($request);
        $array = [
            'project_title' => $request->project_title,
            'project_desc' => $request->project_desc,
        ];
        $project = $this->find($request->project_id);
        $project->update($array);
        $org = $request->project_org;
        $result = $this->assignOrg($project, $org);
//        dd($result);
        return $project->id;
    }

    public function assignOrg($project, $org){
        $projectOrg = $this->getProjectOrganization($project);

        if($projectOrg && $projectOrg != NULL){
            DB::table('organization_projects')->where('project_id', $project->id)->delete();
        }
        $project->organization()->attach($org);
        return $project;
    }

    public function getAllProjects(){
        return $this->get();
    }

    public function projectDetails()
    {
        return $this->hasMany('App\ProjectTaskStatus', 'project_id', 'id');
    }

    public function tasks(){
        return $this->belongsToMany('App\Task', 'project_task_status', 'project_id', 'task_id');
    }

    public function status(){
        return $this->belongsToMany('App\Status', 'project_task_status', 'project_id', 'status_id');
    }
    
    public function getAllProjectsWithDetail(){
        //return $this->with('projectDetails.taskDetail', 'projectDetails.taskStatus')->get();
        return $this->with('tasks.status', 'status')->get();
    }

    public function getProjectOrganization($project){
        $result = $project->organization()->first();
        return $result;
    }

    public function deleteProject($request){
        $project = Projects::find($request->project_id);
        $result = $project->delete();
        return $result;
    }

    public function getProject($request){
        return $this->find($request->project_id);
    }

    public function assignProjectToEmployees($request){
        $projects = $request->projects;
        $employees = $request->employees;
        //dd($projects);
        $projectObj = $this->find($projects);
        if($projectObj && $projectObj != NULL){
            DB::table('user_projects')->where('project_id', $projects)->delete();
            foreach ($employees as $employee){
                $result = $projectObj->user()->attach($employee);
            }
        } else {

            foreach ($employees as $employee){
                $result = $projectObj->user()->attach($employee);
            }
        }
        return $result;
    }

    public function getProjectEmployees($request){
        //dd($request->all());
        $project = $request->project_id;
        $projObj = $this->find($project);
        $res = $projObj->user()->get();
        return $res;
    }

    public function getProjectTasks($request){
        $project = $this->getProject($request);
        $data = $this->with('tasks.status', 'organization', 'user', 'tasks.employees')->where('id', '=', $request->project_id)->get();
//        dd($data);
        return json_encode($data);
    }
}
