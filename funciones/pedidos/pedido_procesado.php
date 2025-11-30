<?php
include('../conexion.php');
$respuesta = new stdClass();
function estado2texto($id){
    switch ($id) {
        case '1':
            return 'En proceso de selección';
            break;
        case '2':
            return 'Pago pendiente';
            break;
        case '3':
            return 'En preparación';
            break; 
        case '4':
            return 'En ruta de entrega';
            break;
        
        case '5':
            return 'Entregado con éxito';
            break;
        default:
        
            break;
    }

}


$datos = array();
$i = 0;
$sql = "SELECT * ,ped.estado estadoped FROM pedido ped 
        INNER JOIN producto pro ON ped.cdpro=pro.cdpro
        WHERE ped.estado!=1";
$stmt = $conn->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $obj = new stdClass();
    $obj->cdped = $row['cdped'];
    $obj->cdpro = $row['cdpro'];
    $obj->nopro = utf8_encode($row['nopro']);
    $obj->costpro = $row['costpro'];
    $obj->rutimg = $row['rutimg'];
    $obj->fchped = $row['fchped'];
    $obj->cantidad = $row['cantidad'];
    $obj->sub_total = $row['sub_total'];
    $obj->dirpedusu = utf8_encode($row['dirpedusu']);
    $obj->celusuped = $row['celusuped'];
    $obj->estado =estado2texto($row['estadoped']);
    $datos[$i] = $obj;
    $i++;
}
$respuesta->datos = $datos;
$conn = null;
header('Content-Type: application/json');
echo json_encode($respuesta);
