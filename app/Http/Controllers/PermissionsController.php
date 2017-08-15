<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use App\User;

class PermissionsController extends Controller
{
    function __construct(){
        $this->user = new User();
        $this->roles = new Roles();
    }

    public function index(){
        $roles = $this->roles->getAllRoles();
        $data = [
            'roles' => $roles
        ];
        return view('permissions.permissions')->with('data', $data);
    }
}
