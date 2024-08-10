<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobApplicationResource;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    /**
     * Store a newly created job application
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_post_id' => 'required|exists:job_posts,id',
            'resume' => 'nullable|mimes:pdf,jpg,png'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => true,
                'message' => 'Validation Failed',
                'error' => $validator->errors()
            ], 422);
        }

        $jobApplication = new JobApplication();
        $jobApplication->job_post_id = $request->job_post_id;
        $jobApplication->applicant_id = $request->user()->id;
        
        if($request->filled('resume'))
        {
            $filename = $request->file('resume')->hashName();
            $filePath = 'uploads/applications/' . $filename;
            $request->file('resume')->storeAs('public/' . $filePath);
            $jobApplication->resume = $filePath;
        }

        $jobApplication->save();

        return response()->json([
            'success' => true,
            'message' => 'Job Application send successfully',
            'data' => new JobApplicationResource($jobApplication)
        ], 200);
    }


    /*
    view job applications as applicants
    */
    public function appliedJobs(Request $request)
    {
        $userId = $request->user()->id;

        $jobApplications = JobApplication::where('applicant_id', $userId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Job Applications fetch successfully',
            'data' => JobApplicationResource::collection($jobApplications)
        ], 200);
    }

    /*
    view job applicants as a job poster
    */
    public function jobApplicants(Request $request)
    {
        $userId = $request->user()->id;

        $jobApplications = JobApplication::whereHas('jobPost', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();

        return response()->json([
            'success' => true,
            'message' => 'Job Applicants fetch successfully',
            'data' => JobApplicationResource::collection($jobApplications)
        ], 200);
    }
}
