<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    //
   use SoftDeletes;

    protected $fillable=['status','id'];
    protected $hidden=[];
     /*
     * @name:    addStatus
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020s
     * * @description:   To insert a status
     */
   public static function addStatus($data)
   {
      return Status::create($data);
   }
    /*
     * @name:    getAllStatus
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To return all status
     */
    public static function getAllStatus()
    {
       return Status::all();
    }
    /*
     * @name:    deleteStatus
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To delete status
     */
    public static function deleteStatus($id)
    {
       $status = Status::findOrFail($id)->delete();
       return $status;
    }
    /*
     * @name:    updateStatus
     * @author:    Sidra Ashfaq
     * @date:   07-3-2020
     * * @description:   To Update a Status with given id
     */
   public static function updateStatus($id, $data)
   {
      $Status = Status::findOrFail($id);
      return $Status->update($data);
   }
}
