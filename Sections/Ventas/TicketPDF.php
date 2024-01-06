<?php 

    include("../../Conexion.php");
    $Folio = $_GET['Folio'];

    $query = "SELECT 
        Ventas.*,
        Empleados.Nombre AS NombreEmpleado,
        COALESCE(Clientes.Nombre, 'Venta general') AS NombreCliente,
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
            Detalle_Venta.Cantidad,
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

        }
    
        function Footer() {
            $this->SetY(-15);
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
    
    // Cambiar el tamaño de la página (ancho, alto)
    $pdf = new PDF('P', 'mm', array(80, 150));
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetMargins(1,1,1,1);

    $pdf->Image('../../Resources/Images/LogoLion.png',3,3,15);
    $pdf->Label(18,9,'Arial','B',12,55,2,'L','PUNTO VENTA ABARROTE  ');
    $pdf->Label(17,18,'Arial','B',12,55,2,'L','Folio:');
    $pdf->Label(15,18,'Arial','',10,55,2,'C',$dataVenta['Folio']);
    $pdf->Label(5,24,'Arial','B',12,55,2,'L','Fecha:');
    $pdf->Label(20,24,'Arial','',10,55,2,'L',$dataVenta['Fecha']);
    $pdf->Label(46,24,'Arial','B',12,55,2,'L','Hora:');
    $pdf->Label(58,24,'Arial','',10,55,2,'L',$dataVenta['Hora']);
    $pdf->Label(5,30,'Arial','B',12,55,2,'L','Caja:');
    $pdf->Label(16,30,'Arial','',10,55,2,'L',$dataVenta['IdCaja']);
    $pdf->Label(27,30,'Arial','B',12,55,2,'L','Comprobante:');
    $pdf->Label(57,30,'Arial','',10,55,2,'L',$dataVenta['TipoDoc']);
    $pdf->Label(14,36,'Arial','B',12,55,2,'L','Cliente:');
    $pdf->Label(30,36,'Arial','',10,55,2,'L',$dataVenta['NombreCliente']);
    $pdf->Label(14,42,'Arial','B',12,55,2,'L','Cajero:');
    $pdf->Label(30,42,'Arial','',10,55,2,'L',$dataVenta['NombreEmpleado']);
    $pdf->Label(0,47,'Arial','B',12,55,2,'C','______________________________');
    $pdf->Label(5,56,'Arial','B',12,55,2,'L','Detalle de venta:');
    $pdf->Label(7,61,'Arial','B',9,55,2,'L','Producto');
    $pdf->Label(36,61,'Arial','B',9,55,2,'L','Cant.');
    $pdf->Label(48,61,'Arial','B',9,55,2,'L','Desc.');
    $pdf->Label(60,61,'Arial','B',9,55,2,'L','Subtotal');

    $y = 67;
    $articulosFinal = 0;
    $descuentoFinal = 0.00;
    $totalFinal = 0.00;
    while ($detalleFila = mysqli_fetch_assoc($detalleResultado)){
        $descAcum = $detalleFila['Cantidad'] * $detalleFila['DescuentoUnitario'];
        $descuentoFinal += $descAcum;
        $articulosFinal += $detalleFila['Cantidad'];
        $totalFinal += $detalleFila['Subtotal'];
        $pdf->Label(7,$y, 'Arial', '', 8, 0, 1, 'L', $detalleFila['NombreProducto']);
        $pdf->Label(40, $y, 'Arial', '', 8, 0, 1, 'L', $detalleFila['Cantidad']);
        $pdf->Label(50, $y, 'Arial', '', 8, 0, 1, 'L', '$'.$descAcum);
        $pdf->Label(63, $y, 'Arial', '', 8, 0, 1, 'L', '$'.$detalleFila['Subtotal']);
        $y += 5;

    }
    $pdf->Label(16, $y+7, 'Arial', 'B', 8, 0, 1, 'L', $articulosFinal);
    $pdf->Label(20, $y+7, 'Arial', 'B', 8, 0, 1, 'L', 'Articulo(s)');
    $pdf->Label(45, $y+7, 'Arial', 'B', 8, 0, 1, 'L', 'Desc. total:');
    $pdf->Label(65, $y+7, 'Arial', '', 8, 0, 1, 'L', '$'.$descuentoFinal);
    $pdf->Label(46, $y+13, 'Arial', 'B', 10, 0, 1, 'L', 'TOTAL:');
    $pdf->Label(63, $y+13, 'Arial', '', 9, 0, 1, 'L', '$'.$totalFinal);

    $pdf->Label(0,$y+18,'Arial','B',12,55,2,'C','______________________________');
    
    $pdf->Label(10,$y+26,'Arial','B',9,55,2,'L','Paga con:');
    $pdf->Label(27,$y+26,'Arial','',9,55,2,'L','$'.$dataVenta['MontoPago']);
    $pdf->Label(42,$y+26,'Arial','B',9,55,2,'L','Cambio:');
    $pdf->Label(56,$y+26,'Arial','',9,55,2,'L','$'.number_format($dataVenta['MontoPago'] - $totalFinal, 2));
    $pdf->Label(0,$y+36,'Arial','B',12,55,2,'C','Equipo 6');

    // Enlace que abrirá una nueva ventana al hacer clic
    
    $pdf->Output();
?>