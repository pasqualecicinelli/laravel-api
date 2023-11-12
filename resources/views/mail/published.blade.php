<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {

            text-align: center;
            background-color: rgb(41, 245, 41)
        }
    </style>
</head>

<body>

    <h1>E' stato {{ $project->published ? 'pubblicato' : 'rimosso' }} il progetto: </h1>
    <h3>{{ $project->name_prog }}</h3>

</body>

</html>
