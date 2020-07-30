<?php

namespace App\Http\Controllers;

use App\Mail\QueryMail;
use App\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class QueryController extends Controller
{
    public function addQuery(Request $request)
    {
        
       $this->validate($request,[
        'query'=>'required',
        'fromUid'=>'required',
        'toUid'=>'required',
        'taskId'=>'required',
        'fromName'=>'required',
        'toName'=>'required',
        'taskTitle'=>'required',
        'toEmail'=>'required|email',
        'fromEmail'=>'required|email'
       ]);
       $input=$request->all();
    
       $queryArray = array(
        'query'=>$input['query'],
        'fromUid'=>$input['fromUid'],
        'toUid'=>$input['toUid'],
        'taskId'=>$input['taskId']
       );
       $emailArray=array(
       'fromName'=> $input['fromName'],
       'toName'=>$input['toName'],
       'query'=>$input['query'],
       'taskTitle'=>$input['taskTitle'],
       'taskId'=>$input['taskId'],
       'fromEmail'=>$input['fromEmail']    
       );
       $query= Query::addQuery($queryArray);
       Mail::to($input['toEmail'])
       ->send(new QueryMail($emailArray));
       if ($query) {
        return response(['message' => 'Query Created']);
    } else {
        return response(['error' => 1, 'message' => 'Query Not Created']);
    }
    }
 
    public static function getTaskQueries($id)
    {
        $query = Query::getTaskQueries($id);
        return $query;
        // return response($query,200);
    }
}
