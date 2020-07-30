<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends PassportTestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $this->assertTrue(true);
    }

    /********** User Details TestCases with middleware **********/
    // public function testGetUsers()
    // {
    //     $response =  $this->get('user');
    //     $this->assertResponseStatus(
    //         200
    //     );
    //     $this->seeJson([
    //         "status" => "OK",
    //     ]);
    // }
    // public function testGetUserById()
    // {
    //     $response =  $this->get('users/1');
    //     $this->assertResponseStatus(
    //         200
    //     );
    //     $this->seeJson([
    //         "status" => "OK",
    //     ]);
    // }
    // public function testEditUser()
    // {
    //     $user=[
    //         'id'=>2,
    //         'name'=>'Umer'
    //     ];
    //     $response=$this->post('editUser',$user);
    //     $response->assertResponseStatus(200);
    //     $response->seeJson([
    //         "message" => "User Updated",
    //     ]);
    // }





    /********** View Data TestCases **********/

    // public function testGetHomeData()
    // {
    //     $taskArray = array(
    //         'type' => 'lead',
    //         'id' => 2
    //     );
    //     $response = $this->post('/homeData', $taskArray);
    //     $response->assertResponseStatus(200);
    //     $response->seeJson([
    //         "status" => "OK",
    //     ]);
    // } 

    // public function testGetEditTaskData()
    // {
    //     $taskArray = array(
    //         'type' => "lead",
    //         'taskId' => 6,
    //         'userId' => 2
    //     );
    //     $response = $this->post('/editTaskData',$taskArray);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson(['status'=>'OK']);
    // }
    // public function testGetStatusData()
    // {
    //     $response = $this->get('/statusData');
    //     $this->assertResponseStatus(200);
    //     $this->seeJson(['message'=>'Record Found']);
    // }
    // public function testGetAdminData()
    // {
    //     $response = $this->get('/allusers');
    //     $this->assertResponseStatus(200);
    //     $this->seeJson(['status'=>'OK']);
    // }



    /**********Task TestCases with middleware **********/
    // public function testDeleteTask()
    // {
    //     $response = $this->delete('task/8');
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Deleted Successfully'
    //     ]);
    // }

    // public function testAddTask()
    // {
    //     $task = factory('App\Task')->make()->toArray();
    //     $response = $this->post('tasks', $task);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Task Created'
    //     ]);
    // }

    // public function testEditTask()
    // {
    //     $taskArray = [
    //         'id'=> 15,
    //         'title'=>"Login Form"
    //     ];
    //     $response = $this->post('editTask',$taskArray);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message'=>'Task Updated'
    //     ]);
    // }

    /**********Query TestCases with middleware **********/
    // public function testAskQuery()
    // {
    //     $queryArray=factory('App\Query')->make()->toArray();
    //     $response=$this->post('askQuery',$queryArray);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message'=>'Query Created'
    //     ]);
    // }


    /**********Status TestCases with middleware **********/
    // public function testAddStatus()
    // {
    //     $statusArray = factory('App\Status')->make()->toArray();
    //     $response = $this->post('status', $statusArray);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Status Created'
    //     ]);
    // }

    // public function testUpdateStatus()
    // {
    //     $statusArray = [
    //         'id' => 4,
    //         'status' => "Demo"
    //     ];
    //     $response = $this->post('updateStatus', $statusArray);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Status Updated'
    //     ]);
    // }

    // public function testDeleteStatus()
    // {
    //     $response = $this->delete('status/5');
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Status Deleted Successfully'
    //     ]);
    // }

    /**********Permissions TestCases with middleware **********/
    // public function testAddPermission()
    // {
    //    $permissionArray = factory("App\Permission")->make()->toArray();
    //    $response= $this->post('permission',$permissionArray);
    //    $this->assertResponseStatus(200);
    //    $this->seeJson([
    //        'message'=>'Permission created successfully'
    //    ]);
    // }

    // public function testGetAllPermissions()
    // {
    //     $response = $this->get('permission');
    //     $this->assertResponseStatus(200);
    //        $this->seeJson([
    //            'message'=>'Permission  Found'
    //        ]);
    // }

    // public function testUpdatePermission()
    // {
    //     $permissionArray = [
    //         'name' => "Demo"
    //     ];
    //     $response = $this->post('permission/3', $permissionArray);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Permission Updated'
    //     ]);
    // }

    // public function testDeletePermission()
    // {
    //     $response = $this->delete('permission/3');
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Permission deleted successfully'
    //     ]);
    // }


    /**********Roles TestCases with middleware **********/
    public function testAddRoles()
    {
        $roleArray = factory("App\Roles")->make()->toArray();
        $response = $this->post('role', $roleArray);
        $this->assertResponseStatus(200);
        $this->seeJson([
            'message' => 'Role created successfully'
        ]);
    }

    // public function testGetAllRoles()
    // {
    //     $response = $this->get('role');
    //     $this->assertResponseStatus(200);
    //        $this->seeJson([
    //            'message'=>'Role  Found'
    //        ]);
    // }

    // public function testUpdateRole()
    // {
    //     $roleArray = [
    //         'name' => "Demo1"
    //     ];
    //     $response = $this->post('role/3', $roleArray);
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => "Role updated successfully"
    //     ]);
    // }

    // public function testDeleteRole()
    // {
    //     $response = $this->delete('role/3');
    //     $this->assertResponseStatus(200);
    //     $this->seeJson([
    //         'message' => 'Role deleted successfully'
    //     ]);
    // }

}
