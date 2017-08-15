<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

//Route::get('/home', 'HomeController@index');


Route::get('/', [
    'as' => 'dashboard',
    'uses' => 'AdminController@index'
]);

Route::get('/404', function () {
    return view('errors.404');
});


Route::get('/logout', [
    'as' => 'logout',
    'uses' => 'AuthenticateController@logout'
]);

Route::get('/roles', [
    'as' => 'roles',
    'uses' => 'RolesController@index'
]);

Route::post('/addRole', [
    'as' => 'addRole',
    'uses' => 'RolesController@addRole'
]);

Route::post('/getRoleById', [
    'as' => 'getRole',
    'uses' => 'RolesController@getRoleById'
]);

Route::post('/deleteRole', [
    'as' => 'deleteRole',
    'uses' => 'RolesController@deleteRole'
]);

Route::get('/permissions', [
    'as' => 'permissions',
    'uses' => 'PermissionsController@index'
]);

Route::group(['middleware' => 'auth'], function (){

    Route::group(['middleware' => 'RolesAndPermission'], function (){
        Route::get('/employees', [
            'permission' => 'employees',
            'as' => 'employees',
            'uses' => 'UserController@index'
        ]);

        Route::get('/assign-designation', [
            'permission' => 'employees',
            'as' => 'assign-designation',
            'uses' => 'UserController@assignDesignation'
        ]);

        Route::get('/assign-organization', [
            'permission' => 'organizations',
            'as' => 'assign-organization',
            'uses' => 'OrganizationController@assignOrganization'
        ]);

        Route::get('/organizations', [
            'permission' => 'organizations',
            'as' => 'organization',
            'uses' => 'OrganizationController@index'
        ]);

        Route::get('/projects', [
            'permission' => 'projects',
            'as' => 'projects',
            'uses' => 'ProjectController@index'
        ]);

        Route::get('/project/{id}', [
            'permission' => 'projects',
            'as' => 'viewProject',
            'uses' => 'ProjectController@viewProject'
        ]);

        Route::get('/assign-project', [
            'permission' => 'projects',
            'as' => 'assign-project',
            'uses' => 'ProjectController@assignProject'
        ]);

        Route::get('/tasks', [
            'permission' => 'tasks',
            'as' => 'tasks',
            'uses' => 'TaskController@index'
        ]);

        Route::get('/assign-task', [
            'permission' => 'tasks',
            'as' => 'assign-task',
            'uses' => 'TaskController@assignTask'
        ]);

        Route::get('/getProjectsWithDetail', [
            'permission' => 'projects',
            'as' => 'getProjectsWithDetail',
            'uses' => 'ProjectController@getProjectsWithDetail'
        ]);


        Route::post('/addEmployee', [
            'permission' => 'employees',
            'as' => 'addEmployee',
            'uses' => 'UserController@employee'
        ]);

        Route::post('/delEmployee', [
            'permission' => 'employees',
            'as' => 'delEmployee',
            'uses' => 'UserController@delEmployee'
        ]);

        Route::post('/updateEmployee', [
            'permission' => 'employees',
            'as' => 'updateEmployee',
            'uses' => 'UserController@updateEmployee'
        ]);

        Route::post('/addDesignation', [
            'permission' => 'employees',
            'as' => 'addDesignation',
            'uses' => 'UserController@addDesignation'
        ]);

        Route::post('/getUserRecord', [
            'permission' => 'employees',
            'as' => 'userRecord',
            'uses' => 'UserController@getUserRecord'
        ]);

        Route::post('/assignOrganizationToSubAdmin', [
            'permission' => 'employees',
            'as' => 'assignOrganization',
            'uses' => 'OrganizationController@assignOrganizationToSubAdmin'
        ]);

        Route::post('/getSubAdminOrg', [
            'permission' => 'organizations',
            'as' => 'getSubAdminOrg',
            'uses' => 'OrganizationController@getSubAdminOrg'
        ]);

        Route::post('/addProject', [
            'permission' => 'projects',
            'as' => 'addProject',
            'uses' => 'ProjectController@addProject'
        ]);
        Route::post('/deleteProject', [
            'permission' => 'projects',
            'as' => 'deleteProject',
            'uses' => 'ProjectController@deleteProject'
        ]);
        Route::post('/getProject', [
            'permission' => 'projects',
            'as' => 'getProject',
            'uses' => 'ProjectController@getProject'
        ]);
        Route::post('/assignProjectToEmployees', [
            'permission' => 'projects',
            'as' => 'assignProjectToEmployees',
            'uses' => 'ProjectController@assignProjectToEmployees'
        ]);
        Route::post('/getProjectEmployees', [
            'permission' => 'projects',
            'as' => 'getProjectEmployee',
            'uses' => 'ProjectController@getProjectEmployees'
        ]);
        Route::post('/addTask', [
            'permission' => 'tasks',
            'as' => 'addTask',
            'uses' => 'TaskController@addTask'
        ]);
        Route::post('/getTask', [
            'permission' => 'tasks',
            'as' => 'getTask',
            'uses' => 'TaskController@getTask'
        ]);

        Route::post('/getTaskAdmin', [
            'permission' => 'tasks',
            'as' => 'getTaskAdmin',
            'uses' => 'TaskController@getTaskAdmin'
        ]);

        Route::post('/deleteTask', [
            'permission' => 'tasks',
            'as' => 'deleteTask',
            'uses' => 'TaskController@deleteTask'
        ]);

        Route::post('/assignTaskToEmployee', [
            'permission' => 'tasks',
            'as' => 'assignTaskToEmployee',
            'uses' => 'TaskController@assignTaskToEmployee'
        ]);

        Route::post('/getProjectTasks', [
            'permission' => 'tasks',
            'as' => 'getProjectTasks',
            'uses' => 'ProjectController@getProjectTasks'
        ]);

        Route::get('/report/{id}', [
            'permission' => 'tasks',
            'as' => 'reports',
            'uses' => 'CommentController@index'
        ]);

        Route::post('submitReport', [
            'permission' => 'tasks',
            'as' => 'submitReport',
            'uses' => 'CommentController@submitReport'
        ]);
    });
});


Route::group(['middleware' => 'guest'], function (){

    Route::get('/login', [
        'as' => 'login',
        'uses' => 'AuthenticateController@login'
    ]);

    Route::post('/login', [
        'as' => 'loginUser',
        'uses' => 'AuthenticateController@loginUser'
    ]);
});



/** Overwritten Routes **/


Route::get('password/reset', function (){
    return view('errors.404');
});

Route::get('password/reset/{token}', function (){
    return view('errors.404');
});

Route::get('register', function (){
    return view('errors.404');
});