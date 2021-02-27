<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required|integer|gte:0',
            'name' => 'required|string',
            'assigned_to' => 'integer|gte:0'
        ]);

        $task = new Task([
            'project_id' => $request->get('project_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'status' => Task::STATUS_TODO,
            'attachments' => null,
            'assigned_to' => $request->get('assigned_to') ? $request->get('assigned_to') : null
        ]);

        if (!$saved = $task->save()) {
            return response()->json([
                'message' => 'Something went wrong when trying to save the task. Please try again'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($request->has('file') && $request->file('file') !== null) {
            $file =  explode('.', $request->file('file')->getClientOriginalName());
            $name = $file[0];
            $extension = $file[1];
            $newName = md5($name) . '.' . $extension;
            $destination = storage_path('upload/tasks/' . $task->id . '/');
            $request->file('file')->move($destination, $newName);
            $task->attachments = [$destination . $newName];
            $task->save();
        }

        /** @var Project $project */
        $project = Project::find($request->get('project_id'));

        if ($request->get('assigned_to') && !$project->hasUser(User::find($request->get('assigned_to')))) {
            $project->users()->attach($request->get('assigned_to'));
            $project->save();
        }

        return \response()->json($task, Response::HTTP_OK);
    }

    public function patch(Request $request, $id)
    {
        /** @var Task $task */
        $task = Task::findOrFail($id);

        foreach ($request->except('_method') as $key => $value) {
            $task->{$key} = $value;
        }

        if (!$saved = $task->save()) {
            return response()->json([
                'message' => 'Something went wrong when trying to save the task. Please try again'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return \response()->json($task, Response::HTTP_OK);
    }
}
