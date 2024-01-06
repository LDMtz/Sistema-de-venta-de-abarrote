<?php
    include("../../Conexion.php");
        $listaCategorias = [];

        //Si me pide una consulta especifica
        if (isset($_POST['tipo_dato'])){
            $tipo_dato=(isset($_POST['tipo_dato']))?$_POST['tipo_dato']:"";
            $dato=(isset($_POST['dato']))?$_POST['dato']:"";

            $query = "SELECT * FROM Categorias WHERE $tipo_dato LIKE '%$dato%'";
            $resultado=mysqli_query($conexion,$query);

            if($resultado)
            while ($fila = mysqli_fetch_assoc($resultado))
                $listaCategorias[] = $fila;
        }
    mysqli_close($conexion);
    if (empty($listaCategorias)) {
        // Si no se encontraron Categorias, imprimir un mensaje
        echo "No se encontraron Categorias.";
    }  
?>

<?php foreach ($listaCategorias as $registro){?>
    <tr class="">
        <td scope="row"><?php echo $registro['IdCategoria']?></td>
        <td><?php echo $registro['Nombre']?></td>
        <td><?php echo $registro['FechaRegistro']?></td>
        <td>
            <a name="" id="" class="btn btn-primary" role="button" 
            onclick="modificaCategoria('<?php echo $registro['IdCategoria'];?>');">Editar</a>

            <a name="" id="" class="btn btn-danger" role="button" 
            onclick="eliminaCategoria('<?php echo $registro['IdCategoria'];?>');">Eliminar</a>
        </td>
    </tr>
<?php }?>