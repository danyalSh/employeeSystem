<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddEmployeeRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\AddEmployeeDesignationRequest;
use App\Http\Requests\AssignOrganizationRequest;
use App\User;
use App\Roles;
use App\Organization;

class UserController extends Controller
{
    public function __construct(){
        $this->user = new User();
        $this->role = new Roles();
        $this->organization = new Organization();
    }

    public function index(){
        $roles = $this->role->getAllRoles();
        $users = $this->user->getAllUsers();

        $data = [
            'roles' => $roles,
            'users' => $users
        ];

        return view('users.employees')->with('data', $data);
    }

    public function employee(AddEmployeeRequest $request){
        try{
            $user_id = $this->user->employee($request);
            return redirect()->back()->with('success', 'User created successfully.');

        } catch (\Exception $e){
            return redirect()->back()->with('failure', 'Error creating user: ' . $e);
        }
    }

    public function updateEmployee(UpdateUserRequest $request){
        try{
            $user_id = $this->user->employee($request);
            return redirect()->back()->with('success', 'Record updated successfully.');
        } catch(\Exception $e){
            dd($e);
        }
    }

    public function delEmployee(Request $request){
        try{
            $result = $this->user->delEmployee($request);
            if($result == true){
                return 1;
            } else {
                return 0;
            }
        } catch(\Exception $e){
            dd($e);
        }
    }

    public function assignDesignation(){
        $users = $this->user->getAllUsers();
        $data = [
            'users' => $users
        ];
        return view('users.designation')->with('data', $data);
    }

    public function addDesignation(AddEmployeeDesignationRequest $request){
//        dd($request->employee_id);
        $result = $this->user->addDesignation($request);
        if($result == true){
            return redirect()->back()->with('success', 'Designation added successfully');
        } else {
            return redirect()->back()->with('failure', 'Something went wrong. Try again!');
        }
    }

    public function getUserRecord(Request $request){
        return $this->user->getUserRecord($request->user_id);
    }

}
