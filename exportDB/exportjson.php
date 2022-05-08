<?php //require_once('./include/pdo_connect.php'); 
include "con_bd.php";

if ( mysqli_connect_errno() ) {
        echo "Error: Ups! Hubo problemas con la conexión.  Favor de intentar nuevamente.";
    } else {
        // Obtener la información de la tabla
        $leer_tabla="select * from productos";
        $res_tabla=$conecta_system->query($leer_tabla);
        $total_rows = $res_tabla->num_rows;         

        if ($total_rows > 0 ) {
            while ($row = $res_tabla->fetch_object()){
                $data[] = $row;
            }

            //print_r($data);
            echo( json_encode($data) );
        } 
    }


?>

