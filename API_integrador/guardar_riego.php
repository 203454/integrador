<?php
?>
<?php
include_once "cors.php";
$riego = json_decode(file_get_contents("php://input"));
include_once "funciones.php";
$resultado = guardarDatos($riego);
echo json_encode($resultado);