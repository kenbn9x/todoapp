<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\Task;

class TaskController extends Controller
{
	/*
	* add task api
	*/
    public function add(Request $request) {
    	// validate data
    	$validator = \Validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'project_id' => 'required'       
                ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'message' => 'Invalid data.',
                'data' => [$validator->errors()]
            ];
            return response()->json($response, 422);
        }

        try{
            $model = new Task();
            $model->title = $request->title;
            $model->project_id = $request->project_id;
            $model->is_completed = Task::INPROGRESS;
            $model->save();
            $response = [
            	'status' => 200,
            	'message' => 'Added successfully',
            	'data' => $model
            ];
        } catch(Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];
        }
        return response()->json($response);   
    }

    /*
    * list tasks
    */

    public function getTasksByProject($projectId) {
    	try{
            $project = Project::select('name', 'description')->where('id', $projectId)->first();
            $results = Task::select('tasks.id', 'tasks.title', 'tasks.is_completed')
                        ->where('tasks.project_id', $projectId)
                        ->orderBy('tasks.id', 'desc')
                        ->get();
            $response = [
                'status' => 200,
                'message' => 'List Tasks',
                'data' => [
                    'project' => $project,
                    'tasks' => $results
                ]
            ];
		} catch(Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];
        }
        return response()->json($response);  
    }

    public function markAsCompleted($id) {
        try{
            $task = Task::find($id);
            if ($task) {
                $task->is_completed = !$task->is_completed;
                $task->save();
                $response = [
                    'status' => 200,
                    'message' => 'Updated successfully',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 422,
                    'message' => 'Bad request.',
                    'data' => [$validator->errors()]
                ];
            }
        } catch(Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];
        }
        return response()->json($response); 
    }
}
