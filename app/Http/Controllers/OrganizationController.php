<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Http\Requests\AssignOrganizationRequest;
use App\Organization;
use App\User;

class OrganizationController extends Controller
{
    function __construct()
    {
        $this->organization = new Organization();
        $this->user = new User();
    }

    public function index(){
        $org = $this->organization->getAllOrganizations();
        $data = [
            'organization' => $org,
        ];
        return view('organization.organization')->with('data', $data);
    }

    public function assignOrganization(){
        $users = $this->user->getRole('Administrator');
//        dd($users);
        $organization  = $this->organization->getAllOrganizations();

        $data = [
            'users' => $users,
            'org' => $organization
        ];
        return view('organization.assignOrganization')->with('data', $data);
    }

    public function assignOrganizationToSubAdmin(AssignOrganizationRequest $request){
//        dd($request->all());
        $result = $this->organization->assignOrganization($request);
        if($result == true){
            return redirect()->back()->with('success', 'Organizations assigned successfully');
        } else {
            return redirect()->back()->with('failure', 'Something went wrong. Try again!');
        }
    }

    public function getSubAdminOrg(Request $request){
//        dd($request->all());
        return $this->organization->getSubAdminOrg($request);
    }
}
