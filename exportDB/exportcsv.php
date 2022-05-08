<?php //require_once('./include/pdo_connect.php'); 

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=export.csv;");

$pdo_conn = new mysqli('localhost', 'root', '', 'proyecto_kmcp');

$sql_select = "SELECT * FROM PRODUCTOS";
$query = $pdo_conn->query($sql_select);

if($query){
    while($r = $query->fetch_object()){
        echo $r->codigo. ",";
        echo $r->catalogo. ",";
        echo $r->tipo. ",";
        echo $r->descripcion. ",";
        echo $r->precio."\n";
    }
}
?>

