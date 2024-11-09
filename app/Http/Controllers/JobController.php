<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index() {
        //$jobs = Job::all();  // n+1 problem (lazy loading the employer relationship)
        //$jobs = Job::with('employer', 'tags')->get(); // eager loading to reduce the number of queries
        //$jobs = Job::with('employer', 'tags')->paginate(3);
        //$jobs = Job::with('employer', 'tags')->simplePaginate(3);
        //$jobs = Job::with('employer', 'tags')->cursorPaginate(3);
        $jobs = Job::with('employer', 'tags')->latest()->simplePaginate(3);
        $jobs = Job::with('employer', 'tags')->latest()->simplePaginate(3);
        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function create() {
        return view('jobs.create');
    }

    public function show(Job $job) {
        return view('jobs.show', ['job' => $job]);
    }

    public function store() {
        request()->validate([
            'title' => ['required', "min:3"],
            'salary' => ['required'],
        ]);

        Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1,
        ]);

        return redirect('/jobs');
    }

    public function edit(Job $job) {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job) {
        // authorize (On hold... )

        request()->validate([
            'title' => ['required', "min:3"],
            'salary' => ['required'],
        ]);
//        $job->title = request('title');
//        $job->salary = request('salary');
//        $job->save();
        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job) {
        // authorize (On hold... )
        $job->delete();
        return redirect('/jobs');
    }
}
