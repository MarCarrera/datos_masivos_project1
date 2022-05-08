<?php
require_once('./include/pdo_connect.php');

$resultData = [];

if(isset($_FILES['xml_data']['name']) &&  $_FILES['xml_data']['name'] != '')
{
	$accept_ext = array('xml');
	$file_data = explode('.', $_FILES['xml_data']['name']);
	$file_ext = end($file_data);
	if(in_array($file_ext, $accept_ext))
	{
		$xml_data = simplexml_load_file($_FILES['xml_data']['tmp_name']);

		echo $xml_data;

		$query = "INSERT INTO productos (codigo, catalogo, tipo, descripcion, precio) VALUES(:codigo, :catalogo, :tipo, :descripcion, :precio);";
		$statement = $pdo_conn->prepare($query);
		for($i = 0; $i < count($xml_data); $i++)
		{
			$result = $statement->execute([
				':codigo'   => $xml_data->producto[$i]->codigo,
				':catalogo'   => $xml_data->producto[$i]->catalogo,
				':tipo'   => $xml_data->producto[$i]->tipo,
				':descripcion'  => $xml_data->producto[$i]->descripcion,
				':precio'  => $xml_data->producto[$i]->precio			
			]);
			
			//echo json_encode($result);

			if(!$result)
			{
				$resultData['status'] = '400';
				$resultData['message'] = 'Documento XML tiene datos invalidos o datos erróneos';
				echo json_encode($resultData);
				exit;
			}

		}
		$resultData['status'] = '200';
		$resultData['message'] = 'Documento XML importado con exito';
	}
	else
	{
		$resultData['status'] = '400';
		$resultData['message'] = 'Formato de documento invalido';
	}
}
else
{
	$resultData['status'] = '400';
	$resultData['message'] = 'Porfavor, escoge un documento XML';
}

echo json_encode($resultData);
?>