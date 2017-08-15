<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Auth;

class Roles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';


    /**
     * Return all Roles Except Super Admin Role
     */
    public function getAllRoles(){
//        return $this->where('id', '!=', '1')->orderBy('created_at', 'desc')->get();
        return $this->where('id', '!=', '1')->get();
    }


    /**
     *The users that have to roles.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
    }

    /**
     *The permissions that belongs to role.
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permissions', 'roles_permissions', 'role_id', 'permission_id');
    }

    public function hasPermissionRole($name)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->name == $name) return true;
        }

        return false;
    }

    public function addRole($request){
//        dd($request->all());
        $data = [
            'name' => $request->role_name
        ];
        $result = $this->create($data);
        return $result;
    }

    public function updateRole($request){
        $array = [
            'name' => $request->role_name,
        ];
        $role = $this->find($request->role_id);
        $role->update($array);
        return $role->id;
    }

    public function deleteRole($request){
        try {
            $role = $this->getRoleById($request);
            $users = $role->users()->get();
            $this->userObj = new User();
            $this->userRole = new UserRole();
            foreach ($users as $user){
                $user_role = $this->userRole->where('user_id', '=', $user->id)->delete();
                $record = $this->userObj->where('id', '=', $user->id)->update([
                    'is_active' => 0
                ]);
            }
            $result = $role->delete();
            return $result;
        } catch (\Exception $e){
            dd($e);
        }

    }

    public function getRoleById($request){
//        dd($request->all());
        return $this->find($request->role_id);
    }
}
