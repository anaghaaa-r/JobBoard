<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobPostResource;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Jobs Fetch Successfull',
            'data' => JobPostResource::collection(JobPost::all())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'salary' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'error' => $validator->errors()
            ], 422);
        }

        $jobPost = new JobPost();
        $jobPost->user_id = $request->user()->id;
        $jobPost->title = $request->title;
        $jobPost->description = $request->description;
        $jobPost->company = $request->company;
        $jobPost->location = $request->location;
        $jobPost->salary = $request->salary;
        $jobPost->save();

        return response()->json([
            'success' => true,
            'message' => 'Job Post Created Successfully',
            'data' => new JobPostResource($jobPost)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {

        return response()->json([
            'success' => true,
            'message' => 'Job Details fetch successfull',
            'data' => new JobPostResource($job)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPost $job)
    {
        Gate::authorize('update', $job);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'company' => 'sometimes|string',
            'location' => 'sometimes|string',
            'salary' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'error' => $validator->errors()
            ], 422);
        }

        $job->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Job Post updated successfully',
            'data' => new JobPostResource($job)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        Gate::authorize('delete', $job);

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job Deleted successfully'
        ], 200);
    }
}
