<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout</title>
    <!-- Archivos CSS -->
    <link rel="stylesheet" href="<?php echo APP_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL ?>css/fontawesome/css/all.css">
</head>

<body class="container-fluid">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <a class="navbar-brand" href="index.php">App Web</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo APP_URL ?>page/create">Agregar Libro</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="pagina2.php">Pagina 2</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown link
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>