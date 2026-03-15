<?php

namespace Model;

class AdminCita extends ActiveRecord
{
    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ['id', 'hora', 'cliente', 'email', 'telefono', 'servicio', 'precio'];

    public $id;
    public $hora;
    public $cliente;
    public $telefono;
    public $email;
    public $servicio;
    public $precio;

    public function __construct($agrs = [])
    {
        $this->id = $agrs['id'] ?? null;
        $this->hora = $agrs['hora'] ?? "";
        $this->cliente = $agrs['cliente'] ?? "";
        $this->telefono = $agrs['telefono'] ?? "";
        $this->email = $agrs['email'] ?? "";
        $this->servicio = $agrs['servicio'] ?? "";
        $this->precio = $agrs['precio'] ?? "";
    }
}
