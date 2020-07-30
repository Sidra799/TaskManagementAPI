<?php

namespace App;

use App\Notifications\TaskCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class Task extends Model
{
   use SoftDeletes, Notifiable;

   //
   protected $fillable = ['id', 'title', 'createdBy', 'startDate', 'priority', 'description', 'assignedUserId', 'duration', 'durationUnit', 'image', 'imagePath', 'statusId', 'endDate'];
   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];

   /************ Relations ************/
   public function developer()
   {
       return $this->belongsTo(User::class,'assignedUserId');
   }

   public function lead()
   {
       return $this->belongsTo(User::class,'createdBy');
   }



   /************ Functions ************/
   /*
     * @name:    addTask
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To insert a task
     */
   public static function addTask($data)
   {
      $task = Task::create($data);
      $developer = $task->developer;
      // Notification::send($developer,new TaskCreated());
      $developer->notify(new TaskCreated());
      $lead = $task->lead;
      return $task;
   }
   /*
     * @name:    getTask
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   A general funtion to view all tasks whether it be lead or developer. It also returns task if any filter is applied
     */
   public static function getAllTasks($input = array(), $id)
   { 

      $dt = DB::table('tasks')
         ->when($input['type'] == 'lead', function ($query) {
            return $query->join('users', 'tasks.assignedUserId', '=', 'users.id');
         })
         ->when($input['type'] == 'developer', function ($query) {
            return $query->join('users', 'tasks.createdBy', '=', 'users.id');
         })
         ->join('statuses', 'tasks.statusId', '=', 'statuses.id')
         ->select('tasks.*', 'users.name', 'statuses.status')
         ->where('tasks.deleted_at', '=', null);
      if (isset($input['type'])) {
         if ($input['type'] == 'lead') {
            $dt = $dt->where('tasks.createdBy', '=', $id);
         }
         if ($input['type'] == 'developer') {
            $dt = $dt->where('tasks.assignedUserId', '=', $id);
         }
      }
      if (isset($input['title'])) {
         $dt = $dt->where('title', $input['title']);
      }
      if (isset($input['date'])) {
         $dt = $dt->where('startDate', $input['date']);
      }
      if (isset($input['priority'])) {
         $dt = $dt->where('priority', $input['priority']);
      }
      if (isset($input['assignTo'])) {
         $dt = $dt->where('assignedUserId', $input['assignTo']);
      }
      return $dt->paginate(env('TASK_PAGINATION'));
   }


   /*
     * @name:    getTaskById
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To return a task with given id
     */
   public static function getTaskById($id)
   {
      return Task::findOrfail($id);
   }
   /*
     * @name:    updateTask
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To Update a task with given id
     */
   public static function updateTask($id, $data)
   {
      $task = Task::findOrFail($id);
      return $task->update($data);
   }
   /*
     * @name:    deleteTask
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To delete Task
     */
   public static function deleteTask($id)
   {
      $task = Task::findOrFail($id)->delete();
      return $task;
   }
   /*
     * @name:    checKDelayedTask
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   return all tasks if tasks are not marked completed and are delayed
     */
   public static function checkDelayedTask()
   {
      $currentDate = date('Y-m-d H:i:s');
      $tasks = DB::table('tasks')
         ->select('tasks.*')
         ->where('tasks.statusId', '!=', env('COMPLETED_STATUS'))
         ->where('tasks.endDate', '<', $currentDate)->get();
      $allTask = [];

      foreach ($tasks as $task) {
         $users = DB::table('users')->select('users.name', 'users.email', 'users.designation')->whereIn('id', [$task->assignedUserId, $task->createdBy])->get();
         $taskId = $task->id;
         $taskDetail = [
            'taskId' => $taskId,
            'users' => $users
         ];
         $allTask[] = $taskDetail;
      }
      return $allTask;
   }
}
