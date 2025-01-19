<?php
class constantes {
    public static $rol = array(
        "Docente" => 5,
        "Preceptor" => 4
    );

    public static function obtenerCodigo($nombreRol) {
        return isset(self::$rol[$nombreRol]) ? self::$rol[$nombreRol] : null;
    }

    public static function obtenerNombreRol($codigoRol) {
        foreach (self::$rol as $nombre => $codigo) {
            if ($codigo === $codigoRol) {
                return $nombre;
            }
        }
        return null;
    }
}
