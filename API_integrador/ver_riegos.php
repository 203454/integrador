<?php
?>
<?php
include_once "cors.php";
include_once "funciones.php";
$riegos = get_riegos();
echo json_encode($riegos);