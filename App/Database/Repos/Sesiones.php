<?php namespace App\Database\Repos;

use App\Core\Tokenizer;
use PDO;
use App\Database\Repo;
use App\Database\Conexion;

class Sesiones extends Repo
{
    public static function traerSesionPorIdUsuario($id)
    {
        $sql = "SELECT * FROM sesiones WHERE usuario_id = :usuario_id";
        
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':usuario_id', $id, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function crearSesion($usuario)
    {
        $token = Tokenizer::createFirstToken($usuario['id'], $usuario['alias']);
        $sql = "INSERT INTO sesiones(usuario_id, hash_privado, fecha_creacion, fecha_modificacion, esta_activa, hash_publico) VALUES(:usuario_id, :hash_privado, NOW(), NOW(), true, :hash_publico)";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':usuario_id', $usuario['id'], PDO::PARAM_STR);
        $sentencia->bindValue(':hash_privado', $token['hash_privado'], PDO::PARAM_STR);
        $sentencia->bindValue(':hash_publico', $token['hash_publico'], PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return $token['hash_publico'];
    }

    public static function activarSesion($sesion)
    {
        $token = Tokenizer::createNewToken($sesion['hash_privado']);

        $sql = "UPDATE sesiones SET fecha_modificacion = NOW(), esta_activa = true, hash_publico = :hash_publico WHERE id = :id";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':id', $sesion['id'], PDO::PARAM_STR);
        $sentencia->bindValue(':hash_publico', $token, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $token;
    }

    public static function traerSesionPorHash($auth)
    {
        $sql = "SELECT * FROM sesiones WHERE hash_publico = :hash_publico";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':hash_publico', $auth, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function traerSesionPorHashPrivado($auth)
    {
        $sql = "SELECT * FROM sesiones WHERE hash_privado = :hash_privado";

        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':hash_privado', $auth, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function cerrarSesion($id)
    {
        $sql = "UPDATE sesiones SET hash_publico = '', fecha_modificacion = NOW(), esta_activa = false WHERE usuario_id = :usuario_id";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':usuario_id', $id, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return;
    }
}