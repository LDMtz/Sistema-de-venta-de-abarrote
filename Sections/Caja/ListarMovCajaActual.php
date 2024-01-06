<?php
        include("../../Conexion.php");
        $listaMovimientos = [];

        $query = "SELECT 
                    MC.IdMov,
                    MC.MontoMov,
                    DATE_FORMAT(MC.FechaHoraMov, '%Y-%m-%d') AS FechaMovimiento,
                    DATE_FORMAT(MC.FechaHoraMov, '%H:%i') AS HoraMovimiento,
                    TM.NombreTipoMov AS TipoMovimiento,
                    E.Nombre AS NombreEmpleado
                FROM 
                    Movimiento_Caja MC
                JOIN
                    Caja C ON MC.IdCaja = C.IdCaja
                JOIN
                    Tipo_Mov_Caja TM ON MC.TipoMov = TM.IdTipoMov
                JOIN
                    Empleados E ON MC.EmpleadoMov = E.IdEmpleado
                WHERE 
                    C.Estado = 1";

        $resultado=mysqli_query($conexion,$query);

        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaMovimientos[] = $fila;

    mysqli_close($conexion);
    if (empty($listaMovimientos)) {
        echo "No se encontraron movimientos de caja.";
    } 

?>

<thead>
    <tr>
        <th scope="col" class="text-nowrap text-center">Id</th>
        <th scope="col" class="text-nowrap text-center">Tipo Movimiento</th>
        <th scope="col" class="text-nowrap text-center">Monto</th>
        <th scope="col" class="text-nowrap text-center">Fecha</th>
        <th scope="col" class="text-nowrap text-center">Hora</th>
        <th scope="col" class="text-nowrap text-center">Empleado Involucrado</th>
    </tr>
</thead>
<tbody id="BodyTabla">
    <?php foreach ($listaMovimientos as $registro) {?>
        <tr class="">
            <td class="text-center"><?php echo $registro['IdMov']?></td>
            <td class="text-center"><?php echo $registro['TipoMovimiento']?></td>
            <td class="text-center"><?php echo '$' . $registro['MontoMov']?></td>
            <td class="text-center"><?php echo $registro['FechaMovimiento']?></td>
            <td class="text-center"><?php echo $registro['HoraMovimiento']?></td>
            <td class="text-center"><?php echo $registro['NombreEmpleado']?></td>
        </tr>
    <?php }?>
</tbody>





