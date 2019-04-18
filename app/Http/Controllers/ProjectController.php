<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $client_id = $request->get('client_id');
       $projects = Project::query();
       if ($client_id) {
           $projects = $projects->whereHas('client', function ($item) use ($request) {
              $item->where('id', $request->client_id);
           });
       }
       return response()->json(['data', $projects->paginate()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $projectData = $request->only([
            'code',
            'name',
            'budget',
            'from',
            'to',
            'client_id'
        ]);
       $client_id = Client::query()->find($request->client_id);
       $project = Project::query()->make($projectData);
       $project->client()->associate($client_id);
       $project->save();

       return response()->json(['data', $project], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
