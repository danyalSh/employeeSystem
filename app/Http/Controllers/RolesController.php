<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddRoleRequest;
use App\Roles;

class RolesController extends Controller
{
    function __construct(){
        $this->roles = new Roles();
    }

    public function index(){
        $roles = $this->roles->getAllRoles();
        $data = [
            'roles' => $roles
        ];
        return view('roles.roles')->with('data', $data);
    }

    public function addRole(AddRoleRequest $request){
        if($request->update == 0){
            $role = $this->roles->addRole($request);
            return collect([
                'status' => 'success',
                'message' => 'Role created successfully!'
            ]);
        } else {
            $role = $this->roles->updateRole($request);
            return collect([
                'status' => 'success',
                'message' => 'Role updated successfully!'
            ]);
        }
    }

    public function deleteRole(Request $request){
//        dd($request->all());
        $role = $this->roles->deleteRole($request);
        if($role == true){
            return collect([
                'status' => 'success',
                'message' => 'Role deleted successfully!'
            ]);
        } else {
            return collect([
                'status' => 'failure',
                'message' => 'Something went wrong. Try again!'
            ]);
        }
    }

    public function getRoleById(Request $request){
        $role = $this->roles->getRoleById($request);
        return $role;
    }


}
