<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->get('pageSize');
        return response()->json(['data', Client::query()->paginate($pageSize)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = Client::query()->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'nipt' => $request->get('nipt'),
        ]);
        return response()->json(['data' => $client], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $client = Client::query()->find($id);
       return response()->json(['data', $client], 200);
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
        $updateClient = Client::query()->find($id);
        $updateClient->name =$request->get('name');
        $updateClient->description= $request->get('description');
        $updateClient->email= $request->get('email');
        $updateClient->phone= $request->get('phone');
        $updateClient->nipt= $request->get('nipt');
        $updateClient->save();
        return $updateClient;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::query()->find($id)->delete();
        return [];
    }
}
