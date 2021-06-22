<?php namespace App\Database\Repos;

use PDO;
use App\Database\Repo;
use App\Database\Conexion;

class Perfil extends Repo
{
    public static function crear($idUsuario, $primerNombre, $segundoNombre = "", $primerApellido, $segundoApellido = '')
    {
        $sql = "INSERT INTO perfil";
        $sql.= "(primer_nom, segundo_nom, primer_ape, segundo_ape)";
        $sql.= "VALUES (:primer_nom, :segundo_nom, :primer_ape, :segundo_ape)";        
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);

        //$sentencia->bindValue(':usuario_id', $idUsuario);
        $sentencia->bindValue(':primer_nom', $primerNombre);
        $sentencia->bindValue(':segundo_nom', $segundoNombre);
        $sentencia->bindValue(':primer_ape', $primerApellido);
        $sentencia->bindValue(':segundo_ape', (is_null($segundoApellido)) ? "" :  $segundoApellido);
        
        $sentencia->execute(); 
        $lastId = $conexion->lastInsertId();  
        $sentencia = $conexion->prepare("SELECT * FROM perfil WHERE id = :id");     
        $sentencia->bindValue(':id', $lastId, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function modificar($idUsuario,$primerNombre, $segundoNombre = "", $primerApellido, $segundoApellido = '')
    {
        $sql = "UPDATE perfil SET";
        $sql.= "(primer_nom, segundo_nom, primer_ape, segundo_ape)";
        $sql.= "VALUES (:primer_nom, :segundo_nom, :primer_ape, :segundo_ape) WHERE id = :id";        
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);

        $sentencia->bindValue(':id', $idUsuario);
        $sentencia->bindValue(':primer_nom', $primerNombre);
        $sentencia->bindValue(':segundo_nom', $segundoNombre);
        $sentencia->bindValue(':primer_ape', $primerApellido);
        $sentencia->bindValue(':segundo_ape', (is_null($segundoApellido)) ? "" :  $segundoApellido);
        
        $sentencia->execute(); 
        $lastId = $conexion->lastInsertId();  
        $sentencia = $conexion->prepare("SELECT * FROM perfil WHERE id = :id");     
        $sentencia->bindValue(':id', $lastId, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function traerPorId($id)
    {
        $sql = "SELECT * FROM perfil WHERE id = :id";
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':id', $id, PDO::PARAM_STR);
        $sentencia->execute();
        Conexion::closeConexion();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }


}