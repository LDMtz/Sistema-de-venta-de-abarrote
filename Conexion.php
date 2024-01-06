<?php
    $servername = "localhost";
    $username = "Leoncio";
    $password = "tPqEo[PGERf(CTVR";
    $dbname = "puntoventa";
    
    // Intentar establecer la conexion
    try {
        $conexion = mysqli_connect($servername, $username, $password, $dbname);
    } catch (Exception $e){
        // Manejar errores de conexion de manera mas controlada
        die("Error de conexion: " . $e->getMessage());
    }
?>