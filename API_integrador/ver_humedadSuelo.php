<?php
?>
<?php
include_once "cors.php";
include_once "funciones.php";
$humedad = get_humedad();
echo json_encode($humedad);