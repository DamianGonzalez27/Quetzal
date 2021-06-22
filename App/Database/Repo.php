<?php namespace App\Database;

use PDO;
use App\Database\Conexion;

class Repo
{
    public static function validateUniquerule($table, $alias, $value)
    {
        $sql = "SELECT * FROM ".$table." WHERE " .$alias." = :".$alias;
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(":".$alias, $value, PDO::PARAM_STR);
        $sentencia->execute();        
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public static function validateSession($hash)
    {
        dd($hash);
    }

    public static function fetchAll($query, $params)
    {
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($query);
        foreach($params as $param)
        {
            $sentencia->bindValue($param['bindName'], $param['bindValue'], PDO::PARAM_STR);
        }
        $sentencia->execute();        
        Conexion::closeConexion();

        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetch($query, $params)
    {
        Conexion::openConexion();
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($query);
        foreach($params as $param)
        {
            $sentencia->bindValue($param['bindName'], $param['bindValue'], PDO::PARAM_STR);
        }
        $sentencia->execute();        
        Conexion::closeConexion();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Funcion para insertar informacion a base de datoss
     * 
     * @param string $query Consulta a base de datos
     * @param array $params Parametros a instertar en la base de datos
     */
    public static function insert($table, $columns, $values, $params)
    {
        Conexion::openConexion();

        $sql = "INSERT INTO " . $table." ". $columns. " VALUES".$values;
        $conexion = Conexion::getConexion();
        $sentencia = $conexion->prepare($sql);
        foreach($params as $param)
        {
            $sentencia->bindValue($param['bindName'], $param['bindValue'], PDO::PARAM_STR);
        }
        $sentencia->execute();
        $lastId = $conexion->lastInsertId();
        $sentencia = $conexion->prepare("SELECT * FROM " . $table . " WHERE id = :id");
        $sentencia->bindValue(':id', $lastId, PDO::PARAM_STR);
        $sentencia->execute();
        
        Conexion::closeConexion();

        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}