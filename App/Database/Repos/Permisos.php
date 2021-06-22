<?php namespace App\Database\Repos;

use PDO;
use App\Database\Conexion;
class Permisos
{
    public static function traerPermisoPorLlave($llave)
    {
        $sql = "SELECT * FROM permisos WHERE llave = :llave";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':llave', $llave, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}