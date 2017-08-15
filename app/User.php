<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Roles;
use App\Organization;

class User extends Authenticatable
{
    use Notifiable;
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
        'first_name', 'last_name', 'username', 'email', 'designation', 'password', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Get Total Users.
     *
     * @var int
     */
    public function getTotalUsers(){
        return $count = $this->where('is_admin', '!=', '1' )->count();
    }

    /**
     * get All Users
     */
    public function getAllUsers(){
        return $this->where('is_admin', '!=', '1')->orderBy('created_at', 'desc')->get();
    }

    /**
     * get a User Record
     */
    public function getUserRecord($id){
        $user = $this->find($id);
        $role = $user->roles()->first();
        $user['role'] = $role->name;
        return $user;
    }

    /**
     * The roles that belongs to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany('App\Roles', 'user_roles', 'user_id','role_id')->withTimestamps();
    }

    public function projects(){
        return $this->belongsToMany('App\Projects', 'user_projects', 'user_id', 'project_id')->withTimestamps();
    }

    public function tasks(){
        return $this->belongsToMany('App\Task', 'user_project_tasks', 'user_id', 'task_id');
    }

//    public function comments(){
//        return $this->belongsToMany('App\Comment', 'user_comments', 'user_id', 'comment_id')->withTimestamps();
//    }

    /**
     * The Organizations that belongs to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations(){
        return $this->belongsToMany('App\Organization', 'user_organizations', 'user_id', 'organization_id')->withTimestamps();
    }

    public function getAllTasksOfProject(){
        return $this->with('tasks')->where();
    }

    /**
     * User has given Role
     * @param $roleName, $user_id
     * @return bool
     */
    public function hasRole($roleName, $user_id = false){
        if($user_id == false){
            $user_id = Auth::user()->id;
        }
        $userObj = $this->find($user_id);
        $userRole = $userObj->roles()->where('name', '=', $roleName)->first();
        if($userRole && $userRole != NULL){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get User Role
     * @param $roleName
     * @return array
     */
    public function getRole($roleName){
        $users = User::whereHas('roles', function($q)use ($roleName){
            $q->where('name', $roleName);
        })->get();
        return $users;
    }


    /**
     * User has Organization
     * @param $user_id
     * @return bool
     */
    public function hasOrg($user_id){
        $userObj = $this->find($user_id);
        $userOrg = $userObj->organizations()->get();
//        dd($userOrg);
        if($userOrg && $userOrg != NULL){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Assign a role to user
     */
    public function assignRole($userObj, $role){
        $userObj->roles()->attach($role);
        return $userObj;
    }

    /**
     * Permissions of Users
     * @param $permission
     * @return mixed
     */
    public function hasPermission($permission){
        foreach ($this->roles()->get() as $role) {
            $result = Roles::where('name', '=', $role->name)->first()->hasPermissionRole($permission);
            return $result;
        }
    }

    /**
     * Create new Employee
     * @param $request
     * @return int
     */
    public function employee($request){
        if($request->employee_id){
            $userObj = $this->find($request->employee_id);
            $role = $userObj->roles()->first();
            if($role->name == 'Administrator'){
                $designation = 'Administrator';
            } else {
                $designation = $request->employee_designation2;
            }
            $array = [
                'first_name' => $request->employee_fname2,
                'last_name' => $request->employee_lname2,
                'username' => $request->employee_username2,
                'email' => $request->employee_email2,
                'is_active' => 1,
                'password' => bcrypt($request->employee_password2),
                'designation' => $designation,
            ];
            $result = $userObj->update($array);
            return $result;
        } else {
            if($request->employee_role == '4' || $request->employee_role == '3'){
                $designation = $request->employee_designation;
            } else {
                $designation = 'Administrator';
            }

            $array = [
                'first_name' => $request->employee_fname,
                'last_name' => $request->employee_lname,
                'username' => $request->employee_username,
                'email' => $request->employee_email,
                'is_active' => 1,
                'password' => bcrypt($request->employee_password),
                'designation' => $designation,
            ];
            $employee = $this->create($array);
            $employeeRole = $request->employee_role;
            $this->assignRole($employee, $employeeRole);
            return $employee->id;
        }
    }

    public function delEmployee($request){

        $user = User::find($request->del_id);
        $result = $user->delete();
        return $result;
    }

    /**
     * Add Designation to Employee
     * @param $request
     * @return void
     */
    public function addDesignation($request){
        return $this->where('id', '=', $request->employee_id)->update(['designation' => $request->employee_designation]);
    }

    public function getUserProjects(){
        $result = $this->with('projects.tasks.status', 'projects.organization', 'projects.user')->where('id', Auth::user()->id)->get();
        return $result;
    }

    public function getUserTasks(){
        $result = $this->tasks()->get();
        return $result;
    }

    public function isAssigned($taskID){
        $task = ProjectTaskStatus::where('task_id', '=', $taskID)->first();
        if($task == NULL){
            return false;
        }
        $result = UserProject::where([
                                    ['user_id', '=', Auth::user()->id],
                                    ['project_id', '=', $task->project_id]
                                ])->get();
        if($result->count() > 0){
            return true;
        } else {
            return false;
        }
    }

    




}
