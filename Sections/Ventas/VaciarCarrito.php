<?php
session_start();

// Vacía el carrito
$_SESSION["carritoV"] = [];
$_SESSION["descuentoCarritoV"] = 0;
$_SESSION["totalCarritoV"] = 0;

// Envía una respuesta (puede ser un JSON, un mensaje simple, etc.)
echo json_encode(['success' => true]);
?>