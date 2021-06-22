<?php namespace App\Database\Repos;

use PDO;
use App\Database\Repo;
use App\Database\Conexion;
class PermisosRol extends Repo
{
    public static function traerPermisosPorIdUsuario($id)
    {
        $sql = "SELECT rol_id FROM usuario WHERE id = :id";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':id', $id, PDO::PARAM_STR);
        $sentencia->execute();
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    
        $sql = "SELECT pr.permiso_id, p.llave FROM permisos_rol pr INNER JOIN permisos p ON pr.permiso_id = p.id WHERE pr.rol_id = :rol_id";
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':rol_id', $usuario['rol_id'], PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}