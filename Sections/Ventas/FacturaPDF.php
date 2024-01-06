<?php 

    include("../../Conexion.php");
    $Folio = $_GET['Folio'];

    $query = "SELECT 
        Ventas.*,
        Empleados.Nombre AS NombreEmpleado,
        COALESCE(Clientes.Nombre, '') AS NombreCliente,
        Clientes.Correo AS CorreoCliente,
        Clientes.Telefono AS TelefonoCliente,
        DATE_FORMAT(FechaHoraRegistro, '%Y-%m-%d') AS Fecha,
        DATE_FORMAT(FechaHoraRegistro, '%H:%i') AS Hora
    FROM Ventas
    LEFT JOIN Empleados ON Ventas.IdEmpleado = Empleados.IdEmpleado
    LEFT JOIN Clientes ON Ventas.IdCliente = Clientes.IdCliente
    WHERE Folio = '$Folio'";

    $resultado=mysqli_query($conexion,$query);
    while ($fila = mysqli_fetch_assoc($resultado)){
        $dataVenta = $fila;
    }

    $idVenta = $dataVenta['IdVenta'];
    
    $detalleQuery = "SELECT 
            Productos.Nombre AS NombreProducto,
            Productos.Descripcion AS DescripcionProducto,
            Detalle_Venta.Cantidad,
            Detalle_Venta.PrecioUnitario,
            Detalle_Venta.DescuentoUnitario,
            Detalle_Venta.Subtotal
        FROM Detalle_Venta
        INNER JOIN Productos ON Detalle_Venta.IdProducto = Productos.IdProducto
        WHERE Detalle_Venta.IdVenta = $idVenta";

        $detalleResultado = mysqli_query($conexion, $detalleQuery);
    
    mysqli_close($conexion);
?>
<?php
    require('../../Libs/fpdf/fpdf.php');

    class PDF extends FPDF {
        function Header() {
            $this->SetFillColor(169, 203, 225);
            $this->Rect(0, 0, $this->w, $this->h, 'F');
        }
    
        function Footer() {
        //     $this->SetFillColor(200, 255, 200); // Relleno verde claro
        //     $this->Rect(0, $this->h - 15, $this->w, 15, 'F');
            $this->SetFont('Arial', 'I', 8);
        }

        function Label($x,$y,$tipo_letra,$negritas,$tam,$espacio_top,$espacio_bot,$align,$label)
        {
            $this->SetFont($tipo_letra,$negritas,$tam);
            $this->Ln($espacio_top);
            $this->setXY($x,$y);
            $this->Cell(0,0,utf8_decode($label),0,0,$align);
            $this->Ln($espacio_bot);
        }
    }
    
    $pdf = new PDF();
    $pdf->AddPage();

    $pdf->Image('../../Resources/Images/LogoLion.png',14,3,30);
    $pdf->Label(48,9,'Arial','B',25,55,2,'L','PUNTO VENTA ABARROTE  ');

    $pdf->setXY(0,25);
    $pdf->SetFont('Courier', '', 40);
    $pdf->SetTextColor(0, 12, 255);
    $pdf->Cell(0,0,utf8_decode('FACTURA'),0,0,'C');
    $pdf->Ln(2);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Label(10,35,'Arial','B',12,55,2,'C','____________________________________________________________________________');
    $pdf->Label(15,46,'Arial','B',14,55,2,'L','FECHA:');
    $pdf->Label(17,51,'Arial','',14,55,2,'L',$dataVenta['Fecha']);

    $pdf->Label(15,64,'Arial','B',14,55,2,'L','HORA:');
    $pdf->Label(17,69,'Arial','',14,55,2,'L',$dataVenta['Hora']);

    $pdf->Label(15,84,'Arial','B',14,55,2,'L','Nº FOLIO:');
    $pdf->Label(17,89,'Arial','',14,55,2,'L',$Folio);

    $pdf->Label(70,46,'Arial','B',14,55,2,'L','CAJA:');
    $pdf->Label(72,51,'Arial','',14,55,2,'L',$dataVenta['IdCaja']);

    $pdf->Label(70,64,'Arial','B',14,55,2,'L','CAJERO:');
    $pdf->Label(72,69,'Arial','',14,55,2,'L',$dataVenta['NombreEmpleado']);

    $pdf->Label(70,84,'Arial','B',14,55,2,'L','COMPROBANTE:');
    $pdf->Label(72,89,'Arial','',14,55,2,'L',$dataVenta['TipoDoc']);


    $pdf->Label(130,46,'Arial','B',14,55,2,'L','DATOS DEL CLIENTE:');
    $pdf->Label(130,56,'Arial','B',14,55,2,'L','Id Cliente:');
    $pdf->Label(158, 56, 'Arial', '', 10, 55, 2, 'L', ($dataVenta['IdCliente'] ? $dataVenta['IdCliente'] : 'Sin cliente'));

    $pdf->Label(130,66,'Arial','B',14,55,2,'L','Nombre:');
    $pdf->Label(154, 66, 'Arial', '', 10, 55, 2, 'L', ($dataVenta['NombreCliente'] ? $dataVenta['NombreCliente'] : 'Sin cliente'));

    $pdf->Label(130,76,'Arial','B',14,55,2,'L','Correo:');
    $pdf->Label(152, 76, 'Arial', '', 10, 55, 2, 'L', ($dataVenta['CorreoCliente'] ? $dataVenta['CorreoCliente'] : 'Sin cliente'));

    $pdf->Label(130,86,'Arial','B',14,55,2,'L','Telefono:');
    $pdf->Label(156, 86, 'Arial', '', 10, 55, 2, 'L', ($dataVenta['TelefonoCliente'] ? $dataVenta['TelefonoCliente'] : 'Sin cliente'));



    // Dibujar una línea vertical como separador
    $pdf->SetLineWidth(0.3); // Ancho de la línea
    $pdf->Line(120, 40, 120, 100);

    $pdf->Label(10,102,'Arial','B',12,55,2,'C','____________________________________________________________________________');
    //$pdf->Label(15,120,'Arial','B',14,55,2,'L','CANT.');

    $pdf->setXY(15,120);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 12, 255);
    $pdf->Cell(0,0,utf8_decode('CANT.'),0,0,'L');
    $pdf->Ln(2);

    $pdf->setXY(35,120);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 12, 255);
    $pdf->Cell(0,0,utf8_decode('PRODUCTO'),0,0,'L');
    $pdf->Ln(2);

    $pdf->setXY(84,120);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 12, 255);
    $pdf->Cell(0,0,utf8_decode('P. UNIT'),0,0,'L');
    $pdf->Ln(2);

    $pdf->setXY(111,120);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 12, 255);
    $pdf->Cell(0,0,utf8_decode('DESC. UNIT'),0,0,'L');
    $pdf->Ln(2);

    $pdf->setXY(138,120);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 12, 255);
    $pdf->Cell(0,0,utf8_decode('DESC. ACUM'),0,0,'L');
    $pdf->Ln(2);

    $pdf->setXY(167,120);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 12, 255);
    $pdf->Cell(0,0,utf8_decode('SUBTOTAL'),0,0,'L');
    $pdf->Ln(2);
    $pdf->Ln(1);

    $pdf->SetTextColor(0, 0, 0);
    
    $articulosFinal = 0;
    $descuentoFinal = 0.00;
    $totalFinal = 0.00;
    while ($detalleFila = mysqli_fetch_assoc($detalleResultado)){
        $descAcum = $detalleFila['Cantidad'] * $detalleFila['DescuentoUnitario'];
        $descuentoFinal += $descAcum;
        $articulosFinal += $detalleFila['Cantidad'];
        $totalFinal += $detalleFila['Subtotal'];
        $pdf->SetLeftMargin(15);
        $pdf->Cell(19, 10, $detalleFila['Cantidad'], 1, 0, 'C', false); // La última opción true indica que se coloreará el fondo
        $pdf->Cell(50, 10, $detalleFila['NombreProducto'].' '.$detalleFila['DescripcionProducto'], 1, 0, 'C', false);
        $pdf->Cell(27, 10, '$'.$detalleFila['PrecioUnitario'], 1, 0, 'C', false);
        $pdf->Cell(27, 10, '$'.$detalleFila['DescuentoUnitario'], 1, 0, 'C', false); // La última opción true indica que se coloreará el fondo
        $pdf->Cell(27, 10, '$'.($detalleFila['Cantidad'] * $detalleFila['DescuentoUnitario']), 1, 0, 'C', false);
        $pdf->Cell(27, 10, '$'.$detalleFila['Subtotal'], 1, 0, 'C', false);
        $pdf->Ln();
    }
    $pdf->Ln();

    //$pdf->setY(15,120);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 12, 255);
    
    $pdf->Cell(19, 10, utf8_decode('ART.'), 0, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode('DESC. TOTAL'), 0, 0, 'L');
    $pdf->Cell(40, 10, utf8_decode('TOTAL'), 0, 0, 'L');
    $pdf->SetX(120);
    $pdf->Cell(36, 10, utf8_decode('PAGO CON'), 0, 0, 'L');
    $pdf->Cell(36, 10, utf8_decode('CAMBIO'), 0, 0, 'L');

    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();

    $pdf->SetX(15);
    $pdf->Cell(19, 10, $articulosFinal, 1, 0, 'C', false); // La última opción true indica que se coloreará el fondo
    $pdf->Cell(40, 10, '$'.$descuentoFinal, 1, 0, 'C', false);
    $pdf->Cell(40, 10, '$'.$totalFinal, 1, 0, 'C', false);
    $pdf->SetX(120);
    $pdf->Cell(36, 10, '$'.$dataVenta['MontoPago'], 1, 0, 'C', false); // La última opción true indica que se coloreará el fondo
    $pdf->Cell(36, 10, '$'.number_format($dataVenta['MontoPago'] - $totalFinal, 2) , 1, 0, 'C', false);
    $pdf->Ln();
    

    $pdf->Output();

?>