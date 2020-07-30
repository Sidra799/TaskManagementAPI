<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
    return response(['message' => $router->app->version()]);
});

$router->post('/register', 'UsersController@register');
$router->post('/login', 'UsersController@login');
$router->post('/forgetPassword', 'UsersController@forgetPassword');
$router->post('/changePassword', 'UsersController@checkPasswordToken');
$router->post('/changePasswordAction', 'UsersController@updatePassword');
$router->get('/email_verification/{code}', 'UsersController@confirmEmail');
$router->post('/sendMessage', 'UsersController@sendMessage');


$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->get('/logout', 'UsersController@logout');
    $router->get('user', 'UsersController@getCurrentUser');
    $router->get('users/{id}', 'UsersController@getUserById');
    $router->post('homeData', 'TaskController@getHomeData');
    $router->post('editTaskData', 'TaskController@getEditTaskData');
    $router->get('statusData', 'StatusController@getStatusData');
    $router->get('allusers', 'TaskController@getAdminData');
    $router->post('editUser', 'UsersController@editUser');
    
    $router->post('tasks', 'TaskController@addTask'); 
    $router->post('editTask', 'TaskController@updateTask');
    $router->post('allTasks', 'TaskController@getAllTask');
    $router->delete('task/{id}',  'TaskController@delete');
    $router->post('askQuery', 'QueryController@addQuery');

    $router->post('status', 'StatusController@addStatus');
    $router->post('updateStatus', 'StatusController@updateStatus');
    $router->delete('status/{id}',  'StatusController@delete');

    $router->post('permission', 'PermissionController@addPermission');
    $router->get('permission', 'PermissionController@getAllPermissions');
    $router->post('permission/{id}', 'PermissionController@updatePermission');
    $router->delete('permission/{id}','PermissionController@deletePermission');

    $router->get('role', 'RoleController@getRoleData');
    $router->post('role', 'RoleController@addRole');
    $router->post('role/{id}', 'RoleController@updateRole');
    $router->get('role/{id}', 'RoleController@getRole');
    $router->delete('role/{id}','RoleController@deleteRole');
});
