<?php namespace App\Database\Repos;

use PDO;
use App\Database\Repo;
use App\Database\Conexion;

class Rol extends Repo
{
    /**
     * Funcion para crear rol
     *
     * @param array $data
     * @return Rol
     */
    public static function crear($data)
    {
        
        $sql = "INSERT INTO roles (nombre, descripcion) VALUES (:nombre, :descripcion)";
        
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue('nombre', $data['nombre']);        
        $sentencia->bindValue('descripcion', $data['descripcion']);        
        $sentencia->execute(); 
        $lastId = $conexion->lastInsertId();  
        $sentencia = $conexion->prepare("SELECT * FROM roles WHERE id = :id");     
        $sentencia->bindValue(':id', $lastId, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Funcion para asignar rol a usuario
     *
     * @param array $data
     * @return Usuario
     */
    public static function asignarRol($data)
    {   
        
        $sql = "UPDATE  usuario SET rol_id = :rol_id WHERE id = :usuario_id";
       
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue('rol_id', $data['rol_id']); 
        $sentencia->bindValue('usuario_id', $data['usuario_id']);    
        $sentencia->execute(); 
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE id = :id");     
        $sentencia->bindValue(':id', $data['usuario_id'], PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Funcion para obtener rol
     *
     * @param int $data
     * @return Rol
     */
    public static function getRol($data)
    {
        $sql = "SELECT * FROM roles WHERE id = :id";
       
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue('id', $data);    
        $sentencia->execute(); 
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}