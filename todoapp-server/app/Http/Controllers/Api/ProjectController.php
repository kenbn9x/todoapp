<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;

class ProjectController extends Controller
{
	/*
	* add project api
	*/
    public function add(Request $request) {
    	// validate data
    	$validator = \Validator::make($request->all(), [
                    'name' => 'required|max:255',
                    'description' => 'required|max:255'         
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
            $model = new Project();
            $model->name = $request->name;
            $model->description = $request->description;
            $model->is_completed = Project::INPROGRESS;
            $model->save();
            $response = [
            	'status' => 200,
            	'msg' => 'Added successfully',
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
    * list projects
    */

    public function index() {
    	try{
	    	$results = Project::select('id', 'name', 'description', 'is_completed')
	    				->orderBy('id', 'desc')
	    				->get();
	    	$response = [
            	'status' => 200,
            	'msg' => 'List Projects',
            	'data' => $results
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
            $project = Project::find($id);
            if ($project) {
                $project->is_completed = !$project->is_completed;
                $project->save();
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
