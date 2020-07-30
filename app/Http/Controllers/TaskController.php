<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Task;
use App\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        $validator = $this->validate($request, [
            'title' => 'required',
            'createdBy' => 'required',
            'startDate' => 'required',
            'priority' => 'required',
            'description' => 'required',
            'assignedUserId' => 'required',
            'duration' => 'required',
            'durationUnit' => 'required',
            'statusId' => 'required'
        ]);
        $input = $request->all();
        if ($input['durationUnit'] == 'days') {
            $time = new DateTime($input['startDate']);
            $time->add(new DateInterval('P' . $input['duration'] . 'D'));
            $endDate = $time->format('Y-m-d H:i:s');
        } else {
            $day = round($input['duration'] / 24);
            if ($day <= 0) {
                $time = new DateTime($input['startDate']);
                $time->add(new DateInterval('PT' . $input['duration'] . 'H'));
                $endDate = $time->format('Y-m-d H:i:s');
            } else {
                $time = new DateTime($input['startDate']);
                $time->add(new DateInterval('P' . $day . 'D'));
                $endDate = $time->format('Y-m-d H:i:s');
            }
        }
        $validator['endDate'] = $endDate;
        $validator['statusId'] = env('TODO_STATUS');
        $task = Task::addTask($validator);
        if ($task) {
            return response(['data'=>$task,'message' => 'Task Created']);
        } else {
            return response(['error' => 1, 'message' => 'Task Not Created']);
        }
    }

    public static function getAllTask(Request $request)
    {
        $id = $request->get('id');
        $title = $request->get('title');
        $date = $request->get('date');
        $priority = $request->get('priority');
        $assignTo = $request->get('assignTo');
        $type = $request->get('type');
        $inputArray = array(
            'type' => $type,
            'title' => $title,
            'date' => $date,
            'priority' => $priority,
            'assignTo' => $assignTo,

        );

        $tableHeading = ["SNO", "Title", "Priority", "Description"];

        if ($request->get('type') == 'lead') {
            array_push($tableHeading, "Assigned User");
        } elseif ($request->get('type') == 'developer') {
            array_push($tableHeading, "Created By");
        }
        array_push($tableHeading, ...["Start Date", "End Date", "Duration", "Status", "Edit"]);



        $task = Task::getAllTasks($inputArray, $id);
        if ($task) {
            return response(
                [
                    'data' => [
                        'allTasks' => $task,
                        'taskPagination' => env('TASK_PAGINATION'),
                        'tableHeading' => $tableHeading
                    ],
                    'message' => 'Record Found'
                ]
            );
        } else {
            return response(['error' => 1, 'message' => 'Record Not Found']);
        }
    }

    public static function getTask($id)
    {
        $task = Task::getTaskById($id);
        return $task;
    }

    public function updateTask(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $id = $request->get('id');
        $task = Task::updateTask($id, $request->all());
        if ($task) {
            return response(['data' => $task, 'message' => 'Task Updated']);
        } else {
            return response(['error' => 1, 'message' => 'Task Not Updated']);
        }
    }
    public function delete($id)
    {
        $task = Task::deleteTask($id);
        if ($task) {
            return response(['message' => 'Deleted Successfully']);
        } else {
            return response(['error' => 1, 'message' => 'Not Deleted Successfully']);
        }
    }

    public function getHomeData(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'type' => 'required'
        ]);
        if ($request->get('type') == 'lead') {
            $assignedUsers = UsersController::getAssignedUsers($request->get('id'));

            if ($assignedUsers) {
                return response(
                    [
                        'data' => [
                            'assignedUsers' => $assignedUsers
                        ],
                        'message' => 'Record Found'
                    ]
                );
            } else {
                return response(['error' => 1, 'message' => 'Record Not Found']);
            }
        }
    }

    public function getEditTaskData(Request $request)
    {
        $designation = $request->get('type');
        $taskId = $request->get('taskId');
        $userId = $request->get('userId');


        $task = TaskController::getTask($taskId);
        $task['startDate'] = date('Y-m-d\TH:i', strtotime($task['startDate']));
        $task['endDate'] = date('Y-m-d\TH:i', strtotime($task['endDate']));


        $status = StatusController::getStatus();

        $allUsers = UsersController::showAllUsers();

        $taskQueries = QueryController::getTaskQueries($taskId);


        if ($designation == 'lead') {
            $assignedUsers = UsersController::getAssignedUsers($userId);
            if ($assignedUsers && $task && $allUsers && $taskQueries && $status) {
                return response(
                    [
                        'data' => [
                            'task' => $task,
                            'assignedUsers' => $assignedUsers,
                            'users' => $allUsers,
                            'queries' => $taskQueries,
                            'status' => $status
                        ],
                        'message' => 'Record Found'
                    ]
                );
            } else {
                return response(['error' => 1, 'message' => 'Record Not Found']);
            }
        }
        if ($task && $allUsers && $taskQueries && $status) {
            return response(
                [
                    'data' => [
                        'task' => $task,
                        'users' => $allUsers,
                        'queries' => $taskQueries,
                        'status' => $status
                    ],
                    'message' => 'Record Found'
                ]
            );
        } else {
            return response(['error' => 1, 'message' => 'Record Not Found']);
        }
    }
    public static function checkDelayedTask()
    {
        return Task::checkDelayedTask();
    }

    public function getAdminData(Request $request)
    {
        $users = UsersController::showAllUsers();
        if ($users) {
            $roles = Roles::getAllRoles();
            $data = [
                'users' => $users,
                'roles' => $roles
            ];
            return response(['data' => $data, 'message' => 'Users Found']);
        } else {
            return response(['error' => 1, 'message' => 'User Not Found']);
        }
    }
}
