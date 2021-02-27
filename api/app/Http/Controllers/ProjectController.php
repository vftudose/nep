<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::whereHas('users', function ($query) {
            return $query->where('user_id', '=', Auth::user()->id);
        })->get();

        return \response()->json($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'start_date' => 'date',
            'end_date' => 'date|required',
        ]);

        $yesterday = (new Carbon())->subDay();
        $startDate = new Carbon($request->get('start_date'));
        $endDate = new Carbon($request->get('end_date'));

        if ($startDate->lessThan($yesterday)) {
            return response()->json([
                'message' => sprintf('Start date cannot be less than %s', $yesterday->addDay()->format('Y-m-d'))
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($endDate->lessThan($startDate)) {
            return response()->json([
                'message' => sprintf('End date cannot be less than %s', $startDate->format('Y-m-d'))
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($endDate->lessThan($yesterday)) {
            return response()->json([
                'message' => sprintf('End date cannot be less than %s', $yesterday->format('Y-m-d'))
            ], Response::HTTP_BAD_REQUEST);
        }

        $project = new Project([
            'name' => $request->get('name'),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'description' => $request->get('description')
        ]);

        if (!$saved = $project->save()) {
            return response()->json([
                'message' => 'Something went wrong when trying to save the project. Please try again'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $project->users()->attach(Auth::user()->id);

        return response()->json($project);
    }

    public function get(int $id): JsonResponse
    {
        $project = Project::with([
            'tasks' => function ($query) {
                if (Auth::user()->role === User::ROLE_CLIENT) {
                    return $query->where('assigned_to', '=', Auth::user()->id);
                }

                return $query;
            },
            'tasks.assignedTo' => function ($query) {
                return $query->select(['id', 'name', 'email']);
            }])->whereHas('users', function ($query) {
            return $query->where('user_id', '=', Auth::user()->id);
        })->where('id', '=', $id)->first();

        if (!$project) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        return response()->json($project);
    }
}
