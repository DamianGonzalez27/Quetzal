<?php namespace App\Database\Repos;

use PDO;
use App\Database\Repo;
use App\Database\Conexion;

class Usuario extends Repo
{
    public static function traerPorId($id)
    {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':id', $id, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function traerPoremail($alias)
    {
        $sql = "SELECT * FROM usuario WHERE alias = :alias";

        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue('alias', $alias, PDO::PARAM_STR); 

        $sentencia->execute();
        Conexion::closeConexion();   

        return $sentencia->fetch(PDO::FETCH_ASSOC);    
    }

    public static function crear($data)
    {
        $sql = "INSERT INTO usuario (alias, llave) VALUES (:alias, :llave)";
        
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue('alias', $data['alias'], PDO::PARAM_STR);        
        $sentencia->bindValue('llave', hash('sha256', $data['llave']), PDO::PARAM_STR);        
        $sentencia->execute(); 
        $lastId = $conexion->lastInsertId();  
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE id = :id");     
        $sentencia->bindValue(':id', $lastId, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function asignarPerfil($usuarioId, $perfilId)
    {
        $sql = "UPDATE usuario SET perfil_id = :perfil_id WHERE id = :id";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':perfil_id', $perfilId, PDO::PARAM_STR);
        $sentencia->bindValue(':id', $usuarioId, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return true;
    }

    public static function traerPerfilPorHash($hash)
    {
        $sesion = Sesiones::traerSesionPorHashPrivado($hash);
        $usuario = self::traerPorId($sesion['usuario_id']);
        $perfil = Perfil::traerPorId($usuario['perfil_id']);
    
        return [
            'alias' => $usuario['alias'],
            'primer_nombre' => $perfil['primer_nom'],
            'primer_apellido' => $perfil['primer_ape']
        ];
    }
}