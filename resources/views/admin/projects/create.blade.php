@extends('layouts.app')

@section('content')
    <h3>Crea un Progetto</h3>


    @if ($errors->any())
        <div class="alert alert-danger">
            <h4>Correggi gli errori:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="col-12 my-3">
            <label for="name_prog"><strong>Nome progetto</strong></label>
            <input class="form-control @error('name_prog') is-invalid @enderror mt-2" type="text" id="name_prog"
                name="name_prog" placeholder="for ex: Titolo nome progetto" aria-label="default input example"
                value="{{ old('name_prog') }}">
            @error('name_prog')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-12 my-3">
            <label for="repo"><strong>Nome della Repo progetto</strong></label>
            <input class="form-control @error('repo') is-invalid @enderror mt-2" type="text" id="repo"
                name="repo" placeholder="for ex: repo-nome-progetto" aria-label="default input example"
                value="{{ old('repo') }}">
            @error('repo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-12 my-3">
            <label for="type_id" class="form-label"><strong>Parte da sviluppare</strong></label>
            <select class="form-select  @error('type_id') is-invalid @enderror" type="text" id="type_id"
                name="type_id">
                <option value="">Nessuna parte sviluppata</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @if (old('type_id') == $type->id) selected @endif>
                        {{ $type->developed_part }}</option>
                @endforeach
            </select>
            @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-12 my-3">
            <label for="link" class="form-label"></label>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon3"><strong>Inserisci il link della Repo</strong></span>
                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" id="link"
                    placeholder="https://example.com/users/" aria-describedby="basic-addon3 basic-addon4"
                    value="{{ old('link') }}">
                @error('link')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-8">
                    <label for="cover_image" class="form-label"><strong>Immagine della cover</strong></label>
                    <input type="file" name="cover_image" id="cover_image"
                        class="form-control @error('cover_image') is-invalid @enderror" value="{{ old('cover_image') }}">
                    @error('cover_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div class="col-4">
                    <img src="" class="img-fluid" id="cover_image_preview">
                </div>
            </div>
        </div>

        <div class="col-12 my-3">
            <div class="row @error('technologies') is-invalid @enderror">
                <div class="my-2"><strong>Check le tecnologie</strong></div>
                @foreach ($technologies as $technology)
                    <div class="col-2 my-2">
                        <input type="checkbox" name="technologies[]" id="technology-{{ $technology->id }}"
                            value="{{ $technology->id }}" class="form-check-control"
                            @if (in_array($technology->id, old('technologies') ?? [])) checked @endif>

                        {{-- Passiamo un array vuoto altrimenti 
                             abbiamo un errore al caricamento della pagina.

                             Stessa funzione scritta leggermente diversa.
                             Sopra sintassi php, questa usa la funzione old
                              @if (in_array($technology->id, old('technologies', []))) checked @endif>
                             --}}

                        <label for="technology-{{ $technology->id }}">
                            {{ $technology->label }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('technologies')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-12 input-group my-4">
            <span class="input-group-text"><strong>Descrizione</strong></span>
            <label for="description" class="form-label"></label>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                aria-label="With textarea">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Salva</button>

        <a href={{ route('admin.projects.index') }} class="btn btn-primary my-3">Indietro</a>

    </form>
@endsection

@section('script')
    <script type="text/javascript">
        const inputFileElem = document.getElementById('cover_image');
        const coverImagePreviw = document.getElementById('cover_image_previw');

        if (!coverImagePreviw.getAttribute('src')) {

            //Se non abbiamo la cover, mettiamo questa img di default
            coverImagePreviw.src = "https://placehold.co/400";
        }

        /** Intercettiamo il 'change' e con file generiamo un URL
         *   questo serve per aggiornare la img di previw
         */
        inputFileElem.addEventListner('change', function() {
            const [file] = this.files;
            coverImagePreviw.src = URL.createObjectUrl(file);
        })
    </script>
@endsection
