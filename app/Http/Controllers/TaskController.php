<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreateTaskRequest;

class TaskController extends Controller
{   
    public function index()
    {
        try{
            $tasks = Task::latest()->paginate(20);
            return view('tasks.index', compact('tasks')); 
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ]); 
           
        }
    }


    public function store(CreateTaskRequest $request)
    {
        try {
            $data = $request->validated();

            DB::beginTransaction();

            $task = Task::create($data);

            $url = env('PROCESS_TASK_URL', 'http://127.0.0.1:5000');

            $response = Http::post($url . '/process-task', [
                'name' => $task->name,
            ]);

            if ($response->successful() && isset($response->json()['message'])) {
                $pythonMessage = $response->json()['message'];

                DB::commit();

                return redirect()->back()->with('message', $pythonMessage);
            } else {
                throw new Exception('Python service did not return a valid message.');
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function update($id)
    {
        try{
            $task = Task::find($id);

            if(!$task){
                return redirect()->back()->with('message', 'Task not found...');
            }
            DB::beginTransaction();
            
            $task->update(['is_completed' => true]);

            DB::commit();

            return redirect()->back()->with('message', 'Task marked as completed.');

        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
