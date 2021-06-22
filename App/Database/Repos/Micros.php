<?php namespace App\Database\Repos;

use PDO;
use App\Database\Repo;
use App\Database\Conexion;

class Micros extends Repo
{
    public static function traerPorNombre($nombre)
    {
        Conexion::openConexion();   
        $sql = "SELECT * FROM micros WHERE nombre = :nombre";
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function traerLlave($idMicro)
    {
        Conexion::openConexion();
        $sql = "SELECT * FROM usuario_micro WHERE micros_id = :id";
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':id', $idMicro, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}