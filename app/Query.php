<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Query extends Model
{
    //
   use SoftDeletes; 

   protected $fillable = ['id','query','fromUid','toUid','taskId','created_at'];
   protected $hidden = [];

   /*
     * @name:    addQuery
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To insert a query
     */
    public static function addQuery($data)
    {
       return Query::create($data);
    }
    /*
     * @name:    getTaskQueries
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To return a query of particular task id
     */
    public static function getTaskQueries($id)
    {
       return DB::table('queries')
       ->join('users', 'queries.fromUid', '=', 'users.id')
       ->select('queries.*', 'users.name')
       ->where('queries.taskId','=',$id)->orderBy('created_at','desc')
       ->where('queries.deleted_at', '=', null)
       ->get();
    }
}
