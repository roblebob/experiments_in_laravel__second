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
    $jobs = Job::with('employer', 'tags')->simplePaginate(3);
    //$jobs = Job::with('employer', 'tags')->cursorPaginate(3);

    return view('jobs', ['jobs' => $jobs]);
});

Route::get('/jobs/{id}', function ($id)  {

    $job = Job::find($id);
    return view('job', ['job' => $job]);
});

Route::get('/contact', function () {
    return view('contact');
});
