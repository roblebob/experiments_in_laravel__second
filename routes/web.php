<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

Route::get('/jobs', function ()  {
    //$jobs = Job::all();  // n+1 problem (lazy loading the employer relationship)
    //$jobs = Job::with('employer')->get(); // eager loading to reduce the number of queries
    //$jobs = Job::with('employer', 'tags')->paginate(3);
    //$jobs = Job::with('employer', 'tags')->simplePaginate(3);
    //$jobs = Job::with('employer', 'tags')->cursorPaginate(3);
    $jobs = Job::with('employer', 'tags')->latest()->simplePaginate(3);


    return view('jobs.index', ['jobs' => $jobs]);   // 'jobs/index' === 'jobs.index'
});

Route::get('/jobs/create', function () {
    return view('jobs.create');
});


Route::get('/jobs/{id}', function ($id)  {

    $job = Job::find($id);
    return view('jobs.show', ['job' => $job]);
});


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



Route::get('/contact', function () {
    return view('contact');
});
