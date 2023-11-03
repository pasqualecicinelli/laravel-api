<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        //Paginate di 5 elem per pagina più ordinamento decrescente
        $projects = Project::orderByDesc("id")->paginate(5);
        return view("admin.projects.index", compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view("admin.projects.create", compact("types", "technologies"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $project = new Project();
        $project->fill($data);

        //Genero lo slug dal name_prog del progetto
        $project->slug = Str::slug($project->name_prog);

        if ($request->hasFile("cover_image")) {

            //prendo il path dallo Storage
            $project->cover_image = Storage::put('uploads/projects/cover_image', $data['cover_image']);
        }

        $project->save();

        if (Arr::exists($data, "technologies"))
            $project->technologies()->attach($data["technologies"]);

        return redirect()->route("admin.projects.show", $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view("admin.projects.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        $tech_ids = $project->technologies->pluck("id")->toArray();

        return view("admin.projects.edit", compact("project", "types", "technologies", "tech_ids"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //Dividiamo le operazioni altrimenti slug non si aggiorna
        $data = $request->validated();
        $project->fill($data);
        $project->slug = Str::slug($project->name_prog);


        if ($request->hasFile("cover_image")) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            //prendo il path dallo Storage
            $project->cover_image = Storage::put('uploads/projects/cover_image', $data['cover_image']);
        }

        $project->save();

        if (Arr::exists($data, "technologies")) {
            $project->technologies()->sync($data["technologies"]);
        } else {
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        $project->delete();
        return redirect()->route('admin.projects.index');
    }

    /**
     * Display Trash "Cestino" a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function trash()
    {
        //Paginate di 5 elem per pagina più ordinamento decrescente
        $projects = Project::onlyTrashed()->orderByDesc("id")->paginate(5);
        return view("admin.projects.trash.index", compact("projects"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */

    public function forceDestroy(int $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        //Best practis
        $project->technologies()->detach();

        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }

        $project->forceDelete();

        return redirect()->route("admin.projects.trash.index");

    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */

    public function restore(int $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $project->restore();

        return redirect()->route("admin.projects.trash.index");

    }

    public function deleteImage(Project $project)
    {
        Storage::delete($project->cover_image);
        $project->cover_image = null;
        $project->save();
        return redirect()->back();
    }
}