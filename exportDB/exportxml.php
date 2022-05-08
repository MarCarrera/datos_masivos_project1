<?php //require_once('./include/pdo_connect.php'); 

    include "con_bd.php";

    if ( mysqli_connect_errno() ) {
        echo "Error: Ups! Hubo problemas con la conexión.  Favor de intentar nuevamente.";
    } else {
        header("Content-Type: text/xml");
        // Obtener la información de la tabla
        $leer_tabla="select * from productos";
        $res_tabla=$conecta_system->query($leer_tabla);
            

        echo("<productos>");

        while($r = mysqli_fetch_row($res_tabla)){
            echo("<producto>");

            echo("<codigo>$r[0]</codigo>");
            echo("<catalogo>$r[1]</catalogo>");
            echo("<tipo>$r[2]</tipo>");
            echo("<descripcion>$r[3]</descripcion>");
            echo("<precio>$r[4]</precio>");
            echo("</producto>");
    }
        echo("</productos>"); 
    }

    

?>