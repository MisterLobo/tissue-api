<?php

namespace App\Services\Api\Http\Controllers;

use App\Services\Api\Features\FetchProjectsFeature;
use App\Services\Api\Features\FetchUserProjectsFeature;
use App\Services\Api\Features\MakeUserProjectFeature;
use Framework\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Http\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        //
    }

    /**
     * Get all projects for authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserProjects()
    {
        return $this->serve(FetchUserProjectsFeature::class);
    }

    /**
     * Get all user projects
     *
     * @return \Illuminate\Http\Response
     */
    public function getProjects()
    {
        return $this->serve(FetchProjectsFeature::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importUserProjects()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Create a project for the authenticated user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->serve(MakeUserProjectFeature::class);
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
