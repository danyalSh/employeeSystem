<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Projects;


class Organization extends Model
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
    protected $table = 'organizations';

    /**
     * Get Total Organizations Count.
     *
     * @return int
     */
    public function getTotalOrganization(){
        return $count = $this->count();
    }

    /**
     * Get Total Organizations.
     * @return array
     */
    public function getAllOrganizations(){
        return $count = $this->get();
    }

    /**
     * Get Organization of all Sub Admins.
     * @return array
     */
    public function getOrganizationAdmin(){
        return $this->users()->where('user_id', '!=', 1)->first();
    }

    /**
     * Get Sub Admin Organizations.
     * @return array
     */
    public function getSubAdminOrg($request){
        $userObj = User::find($request->employee_id);
        $res = $userObj->organizations()->get();
//        dd($res);
        return $res;
    }

    /**
     *The users that have to Organizations.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_organizations', 'organization_id', 'user_id');
    }

    /**
     * Assign Organization to Sub Admin
     * @param $request
     * @return void
     */
    public function assignOrganization($request){
        if($request->update == 1){
            $subAdminOrg = $this->getSubAdminOrg($request);

            if($subAdminOrg && $subAdminOrg != NULL){
                DB::table('user_organizations')->where('user_id', $request->employee_id)->delete();
            }
        }

        $userObj = User::find($request->employee_id);
        foreach($request->org_id as $org_id){
            $userObj->organizations()->attach($org_id);
        }
        return $userObj;
    }

    public function projects(){
        return $this->belongsToMany('App\Projects','organization_projects', 'organization_id', 'project_id');
    }
}
