<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::select("id", "name_prog", "link", "slug", "type_id")
            ->with('technologies:id,label,color', 'type:id,developed_part')
            ->orderByDesc('id')
            ->paginate(4);
        return response()->json($projects);

        //Specifichiamo i campi che vogliamo vedere in vue
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::select("id", "name_prog", "link", "slug", "type_id")
            ->where('id', $id)
            ->with('technologies:id,label,color', 'type:id,developed_part')
            ->first();
        return response()->json($project);
    }

}