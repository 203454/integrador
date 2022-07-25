<?php
 ?>
<?php
function get_user($email)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT * FROM usuarios WHERE email LIKE '$email");
    $sentencia->execute([$email]);
    return $sentencia->fetchObject();
}

function obtenerUsuarios()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT * FROM users");
    return $sentencia->fetchAll();
}

function get_riegos()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT * FROM riego");
    return $sentencia->fetchAll();
}

function get_humedad()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT humedad_suelo FROM riego");
    return $sentencia->fetchAll();
}


function guardarDatos($riego)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("INSERT INTO riego(temperatura, humedad,humedad_suelo,estado_agua) VALUES (?, ?, ?, ?)");
    return $sentencia->execute([$riego->temperatura, $riego->humedad, $riego->humedad_suelo, $riego->estado_agua]);
}

function obtenerVariableDelEntorno($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "env.php";
        if (!file_exists($file)) {
            throw new Exception("El archivo de las variables de entorno ($file) no existe. Favor de crearlo");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("La clave especificada (" . $key . ") no existe en el archivo de las variables de entorno");
    }
}
function obtenerConexion()
{
    $password = obtenerVariableDelEntorno("MYSQL_PASSWORD");
    $user = obtenerVariableDelEntorno("MYSQL_USER");
    $dbName = obtenerVariableDelEntorno("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}