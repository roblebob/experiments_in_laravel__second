<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

// Index: displays all jobs
/*Route::get('/jobs', function ()  {
    //$jobs = Job::all();  // n+1 problem (lazy loading the employer relationship)
    //$jobs = Job::with('employer', 'tags')->get(); // eager loading to reduce the number of queries
    //$jobs = Job::with('employer', 'tags')->paginate(3);
    //$jobs = Job::with('employer', 'tags')->simplePaginate(3);
    //$jobs = Job::with('employer', 'tags')->cursorPaginate(3);
    $jobs = Job::with('employer', 'tags')->latest()->simplePaginate(3);
    return view('jobs.index', ['jobs' => $jobs]);   // 'jobs/index' === 'jobs.index'
});*/
Route::get('/jobs', [JobController::class, 'index']);




// Create: displays a form to create a new job
Route::get('/jobs/create', function () {
    return view('jobs.create');
});


// Show: displays a single job
//Route::get('/jobs/{id}', function ($id)  {
//    $job = Job::find($id);
//    return view('jobs.show', ['job' => $job]);
//});
Route::get('/jobs/{job:id}', function (Job $job)  {   // 'id' is the name of the route parameter (default, can be omitted)
    return view('jobs.show', ['job' => $job]);
});

// Store: persists the new job to the database
Route::post('/jobs', function () {
    //dd(request()->all());

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
});

// Edit: displays a form to edit a job
//Route::get('/jobs/{id}/edit', function ($id)  {
//    $job = Job::find($id);
//    return view('jobs.edit', ['job' => $job]);
//});
Route::get('/jobs/{job}/edit', function (Job $job)  {
    return view('jobs.edit', ['job' => $job]);
});

// Update:
//Route::patch('/jobs/{id}', function ($id)  {
//    request()->validate([
//        'title' => ['required', "min:3"],
//        'salary' => ['required'],
//    ]);
//
//    // authorize (On hold... )
//
//    // update the job
//    $job = Job::findOrFail($id);
//
////    $job->title = request('title');
////    $job->salary = request('salary');
////    $job->save();
//    $job->update([
//        'title' => request('title'),
//        'salary' => request('salary'),
//    ]);
//
//    return redirect('/jobs/' . $job->id);
//});
Route::patch('/jobs/{job}', function (Job $job)  {
    // authorize (On hold... )

    request()->validate([
        'title' => ['required', "min:3"],
        'salary' => ['required'],
    ]);

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    return redirect('/jobs/' . $job->id);
});

// Destroy
//Route::delete('/jobs/{id}', function ($id)  {
//    // authorize (On hold... )
//    Job::findOrFail($id)->delete();
//    return redirect('/jobs');
//});
Route::delete('/jobs/{job}', function (Job $job)  {
    // authorize (On hold... )
    $job->delete();
    return redirect('/jobs');
});



Route::get('/contact', function () {
    return view('contact');
});
