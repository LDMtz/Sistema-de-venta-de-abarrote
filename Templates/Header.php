<?php
    session_start();
    $url_base="http://localhost:8080/PuntoVentaAbarrote/";
    if(!isset($_SESSION['Nombre'])){
        header("Location:".$url_base."Login.php");
    }

    // Obtiene la URL actual
    $url = $_SERVER['REQUEST_URI'];
    // Verifica si la URL contiene una carpeta
    if (strpos($url, '/Sections') !== false) { // Si el index está en una carpeta
        $ruta = "../../";
    } else {// Si el index no está en una carpeta
        $ruta = "";
    }


?>

<!doctype html>
<html lang="en">

<head>
    <title>Punto de Venta Abarrote - Equipo 6</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="icon" type="image/png" href="<?php echo $ruta . "Resources/Images/logo.png"; ?>"/>

    <link rel="stylesheet" href="<?php echo $ruta . "Libs/bootstrap.min.css"; ?>"/>

    <link rel="stylesheet" href="<?php echo $ruta . "Css/Styles.css"; ?>" />
    
    <script type="text/javascript" src="<?php echo $ruta . "Libs/jquery.js"; ?>"></script>

    <script type="text/javascript" src="<?php echo $ruta . "Libs/sweetalert.min.js"; ?>"></script>

</head>
<body>
    <header>
        <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="col-md-1">
                <h3 class="m-1">Sistema</h3>
            </div>

            <div class="col-md-9">
            <ul class="nav navbar-nav  justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Ventas/index.php">Ventas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Compras/index.php">Compras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Productos/index.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Categorias/index.php">Categorias</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Inventario/index.php">Inventario</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Arqueo/index.php">Arqueo</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Caja/index.php">Caja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Empleados/index.php">Empleados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Proveedores/index.php">Proveedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Clientes/index.php">Clientes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Facturas/index.php">Facturas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>Sections/Reportes/index.php">Reportes</a>
                </li>
            </ul>
            </div>

            <div class="col-md-2 align-items-center d-flex">
                <img class="img-nav m-1 rounded-circle"  src="<?php echo $ruta."Sections/Empleados/Fotos/".$_SESSION['Foto'];?>" alt="imgUser">
                <h7 class="text-center m-2 center"><?php echo $_SESSION['Nombre'];?></h7>
                <button name="" id="" class="btn btn-primary m-1 ms-auto" onclick="cerrarSesion();">
                    <img class="svg-icon" src="<?php echo $ruta . "Resources/Icons/logout.svg";?>" alt="">
                </button>
            </div>
        
        </nav>
    </header>
  <main id="main" class="container">

  <script>
    $(document).ready(function() {
        var url = window.location.href;
        var enlacesMenu = $('.nav-link');
        var seccionActual = obtenerSeccionActual(url);

        enlacesMenu.each(function() {
            var href = $(this).attr('href');
            // Comprueba si la sección actual está presente en el href del enlace
            if (href.includes(seccionActual) && href !== '#' && href !== '') {
                $(this).addClass('active fw-bold text-primary');
            }
            else if(seccionActual == 'SinSeccion'){
                $(this).addClass('active fw-bold text-primary');
                return false;
            }
        });

        // Función para obtener la sección actual de la URL
        function obtenerSeccionActual(url) {
            // Divide la URL por '/'
            var partes = url.split('/');
            // Encuentra la sección en la que nos encontramos (por ejemplo, "Empleados")
            var seccion = partes[partes.length - 2];
            if (seccion == 'PuntoVentaAbarrote') {
                seccion = 'SinSeccion';
            }
            
            return seccion;
        }
    });

    function cerrarSesion(){
        swal({
            title: "¿Estás seguro que quieres salir?",
            text: "Si das click en Ok, se cerrará la sesión",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((cerrar) => {
            if (cerrar) {
                // Obtén la ruta actual de la página
                var url = window.location.pathname;
                // Verifica si la URL contiene una carpeta llamada 'Sections'
                if (url.indexOf('/Sections') !== -1) {
                    window.location.href = '../../CerrarSesion.php';
                } else {
                    window.location.href = 'CerrarSesion.php';
                }
            }
        });
    }
    
</script>





