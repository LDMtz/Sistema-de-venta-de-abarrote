<?php
if(isset($_POST)){
    include("../../Conexion.php");
    $Id=(isset($_POST['IdProductoForm']))?$_POST['IdProductoForm']:"";

    $query = "SELECT
                    Productos.IdProducto,
                    Productos.CodigoBarras,
                    Productos.Nombre, 
                    Productos.Foto, 
                    Productos.Descripcion, 
                    Productos.PrecioCompra, 
                    Productos.PrecioVenta, 
                    Productos.Existencias, 
                    Productos.FechaRegistro, 
                    CASE 
                        WHEN Productos.Estado = 1 THEN 'Activo' 
                        ELSE 'Inactivo' 
                    END AS Estado, 
                    Categorias.Nombre AS NombreCategoria, 
                    Proveedores.Nombre AS NombreProveedor
                FROM Productos
                INNER JOIN Categorias ON Productos.IdCategoria = Categorias.IdCategoria
                INNER JOIN Proveedores ON Productos.IdProveedor = Proveedores.IdProveedor
                WHERE Productos.IdProducto = '$Id'";

            $resultado=mysqli_query($conexion,$query);

    if($resultado && mysqli_num_rows($resultado) > 0)
        while ($fila = mysqli_fetch_assoc($resultado))
                $producto = $fila;
    

    mysqli_close($conexion);

    ?>

    
    <?php
    // ---------------------------------------------------------------------------------------------------------------------//
    require('../../Libs/fpdf/fpdf.php');

    class PDF extends FPDF
    {
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../../Resources/Images/LogoLion.png',10,8,20);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,15,'Sistema: Punto de Venta de Abarrote - Equipo 6',0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

    function Label($x,$y,$tipo_letra,$negritas,$tam,$espacio_top,$espacio_bot,$align,$label)
    {
        $this->SetFont($tipo_letra,$negritas,$tam);
        $this->Ln($espacio_top);
        $this->setXY($x,$y);
        $this->Cell(0,0,utf8_decode($label),0,0,$align);
        $this->Ln($espacio_bot);
    }

    // Pie de página
    function Footer()
    {
        /*
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        */
    }
}

    
    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    //Datos del producto
    $pdf->Label(15,43,'Arial','B',20,10,2,'L','Información del Producto:');

    //Imagen:
    $pdf->Image(('Fotos/'.$producto['Foto']),80,50,40);
    //Id
    $pdf->Label(15,103,'Arial','B',14,55,2,'L','ID:');
    $pdf->Label(25,103,'Arial','',12,0,0,'L',$producto['IdProducto']);

    $pdf->Label(15,113,'Arial','B',14,55,2,'L','Código de Barras:');
    $pdf->Label(63,113,'Arial','',12,0,0,'L',$producto['CodigoBarras']);

    $pdf->Label(15,123,'Arial','B',14,55,2,'L','Nombre:');
    $pdf->Label(40,123,'Arial','',12,0,0,'L',$producto['Nombre']);

    $pdf->Label(15,133,'Arial','B',14,55,2,'L','Descripción:');
    $pdf->Label(50,133,'Arial','',12,0,0,'L',$producto['Descripcion']);

    $pdf->Label(15,143,'Arial','B',14,55,2,'L','Existencias:');
    $pdf->Label(50,143,'Arial','',12,0,0,'L',$producto['Existencias']);

    $pdf->Label(15,153,'Arial','B',14,55,2,'L','Precio Compra:');
    $pdf->Label(60,153,'Arial','',12,0,0,'L','$'.$producto['PrecioCompra']);

    $pdf->Label(15,163,'Arial','B',14,55,2,'L','Precio Venta:');
    $pdf->Label(55,163,'Arial','',12,0,0,'L','$'.$producto['PrecioVenta']);

    $pdf->Label(15,173,'Arial','B',14,55,2,'L','Proveedor:');
    $pdf->Label(50,173,'Arial','',12,0,0,'L',$producto['NombreProveedor']);

    $pdf->Label(15,183,'Arial','B',14,55,2,'L','Categoría:');
    $pdf->Label(50,183,'Arial','',12,0,0,'L',$producto['NombreCategoria']);

    $pdf->Label(15,193,'Arial','B',14,55,2,'L','Estado:');
    $pdf->Label(40,193,'Arial','',12,0,0,'L',$producto['Estado']);

    $pdf->Label(15,203,'Arial','B',14,55,2,'L','Fecha de Registro:');
    $pdf->Label(68,203,'Arial','',12,0,0,'L',$producto['FechaRegistro']);

    $pdf->Output();
}

?>


