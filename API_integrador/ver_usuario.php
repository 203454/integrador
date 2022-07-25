<?php
?>
<?php
include_once "cors.php";
if (!isset($_GET["email"])) {
    echo json_encode(null);
    exit;
}
$email = $_GET["email"];
include_once "funciones.php";
$usuario = get_user($email);
echo json_encode($usuario);