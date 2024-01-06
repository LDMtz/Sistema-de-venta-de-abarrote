<?php 
    include("../../Conexion.php");

    $query="SELECT * FROM Categorias";
    $resultado=mysqli_query($conexion,$query);
    $listaCategorias = array();

    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaCategorias[] = $fila;// Agregar la fila actual al array $listaCategorias

    mysqli_close($conexion);
?>

<?php foreach ($listaCategorias as $registro){?>
    <tr class="container">
        <td scope="row"><?php echo $registro['IdCategoria']?></td>
        <td class="col-6"><?php echo $registro['Nombre']?></td>
        <td class="col-3"><?php echo $registro['FechaRegistro']?></td>
        <td>
            <a name="" id="" class="btn btn-primary" role="button" 
            onclick="modificaCategoria('<?php echo $registro['IdCategoria'];?>');">Editar</a>

            <a name="" id="" class="btn btn-danger" role="button" 
            onclick="eliminaCategoria('<?php echo $registro['IdCategoria'];?>');">Eliminar</a>
        </td>
    </tr>
<?php }?>