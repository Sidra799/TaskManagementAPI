<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function addStatus(Request $request)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);
        $status = Status::addStatus($request->all());
        if ($status) {
            return response(['message' => 'Status Created']);
        } else {
            return response(['error' => 1, 'message' => 'Status Not Created']);
        }
    }
    public static function getStatus()
    {
        return  Status::getAllStatus();
    }
    public function updateStatus(Request $request)
    {
        $validator = $this->validate($request, [
            'id' => 'required'
        ]);
        $input = $request->all();
        $id = $input['id'];
        $status = Status::updateStatus($id, $request->all());
        if ($status) {
            return response(['message' => 'Status Updated']);
        } else {
            return response(['error' => 1, 'message' => 'Status Not Updated']);
        }
    }
    public function delete($id)
    {
        $status = Status::deleteStatus($id);
        if ($status) {
            return response(['message' => 'Status Deleted Successfully']);
        } else {
            return response(['error' => 1, 'message' => 'Status Not Deleted Successfully']);
        }
    }
    public function getStatusData()
    {
        $status = StatusController::getStatus();
        if ($status) {
            return response(['data' => $status, 'message' => 'Record Found']);
        } else {
            return response(['error' => 1, 'message' => 'Record Not Found']);
        }
    }
}
