<?php


namespace Model;

class Servicio extends ActiveRecord
{
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($agrs = [])
    {
        $this->id = $agrs['id'] ?? null;
        $this->nombre = $agrs['nombre'] ?? '';
        $this->precio = $agrs['precio'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = "El nombre del servicios es obligatorio";
        }
        if (!$this->precio) {
            self::$alertas['error'][] = "El precio del servicios es obligatorio";
        }

        if (!is_numeric($this->precio)) {
            self::$alertas['error'][] = "El precio debe ser un numero";
        }

        return self::$alertas;
    }
}
