@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <a href="{{ route('admin.projects.create') }}" role="button" class="btn btn-primary">Crea Progetto</a>
    <a href="{{ route('admin.projects.trash.index') }}" role="button" class="btn btn-primary">Vai al Cestino</a>

    <h1 class="my-5">Lista dei Progetti</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome progetto</th>
                <th scope="col">Nome della repo</th>
                <th scope="col">Parte sviluppata</th>
                <th scope="col">Tecnologia</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
                <th scope="col">D-T-M</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->name_prog }}</td>
                    <td>{{ $project->repo }}</td>
                    <td>{{ $project->type?->developed_part }}</td>
                    <td class="col-2">{!! $project->getTechBadges() !!}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>{{ $project->updated_at }}</td>
                    <td>
                        <a href="{{ route('admin.projects.show', $project) }}"><i
                                class="fa-solid text-primary fa-eye"></i></a>

                        <a href="{{ route('admin.projects.edit', $project) }}"><i
                                class="fa-solid text-warning fa-pen-to-square px-1"></i></a>

                        <!-- Button trigger modal -->
                        <a href="#" type="button" data-bs-toggle="modal"
                            data-bs-target="#delete-modal-{{ $project->id }}"><i
                                class="fa-solid text-danger fa-trash-can"></i></a>
                    </td>
                </tr>

            @empty <h4 class="my-5">Non ci sono progetti</h4>
            @endforelse
        </tbody>
    </table>

    {{ $projects->links('pagination::bootstrap-5') }}

    <div class="d-flex flex-column">
        <h5>*Leggenda D-T-M</h5>
        <span>Mostra i dettagli del Progetto: <i class="fa-solid text-primary fa-eye"></i></span>
        <span>Modifica un Progetto: <i class="fa-solid text-warning fa-pen-to-square px-2"></i></span>
        <span>Sposta nel Cestino un Progetto: <i class="fa-solid text-danger fa-trash-can"></i></span>

    </div>
@endsection

@section('modals')
    @foreach ($projects as $project)
        <!-- Modal -->
        <div class="modal fade" id="delete-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModal"> Vuoi spostare
                            questo progetto nel cestino?
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span>Progetto numero: </span> {{ $project->id }} <br>
                        <span>Nome del progetto: </span>
                        {{ $project->name_prog }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
