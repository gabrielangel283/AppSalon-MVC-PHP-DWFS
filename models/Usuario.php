<?php

namespace Model;


class Usuario extends ActiveRecord
{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'admin', 'confirmado', 'token', 'password'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $password;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->apellido = $args['apelido'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->telefono = $args['telefono'] ?? null;
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? null;
    }

    public function validarNuevaCuenta()
    {
        self::$alertas = [];

        if (!trim($this->nombre)) {
            self::$alertas['error'][] = "El nombre del cliente es obligatorio";
        }

        if (!trim($this->apellido)) {
            self::$alertas['error'][] = "El apellido del cliente es obligatorio";
        }

        if (!trim($this->email)) {
            self::$alertas['error'][] = "El email de contacto es obligatorio";
        }

        if (strlen(trim($this->telefono)) > 0 && !preg_match("/^[0-9]+$/", $this->telefono)) {
            self::$alertas['error'][] = "El telefono solo debe incluir números";
        }

        if (!trim($this->password)) {
            self::$alertas['error'][] = "La contraseña es obligatorio";
        }

        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = "La contraseña es muy debil. Debe contener almenos 6 caracteres";
        }

        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!trim($this->email)) {
            self::$alertas['error'][] = "El email de contacto es obligatorio";
        }
        return self::$alertas;
    }


    public function existeUsuario()
    {
        $sql = "select * from " . self::$tabla . " where email='$this->email' limit 1";

        $resultado = self::$db->query($sql);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = "El correo ingresado ya esta regisrado";
        }

        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }

    public function validarLogin()
    {
        if (!trim($this->email)) {
            self::$alertas['error'][] = "El email es obligatorio";
        }

        if (!trim($this->password)) {
            self::$alertas['error'][] = "El password es obligatorio";
        }

        return self::$alertas;
    }

    public function comprobarPasswordAndVerificado($pass)
    {
        $resultado = password_verify($pass, $this->password);

        if (!$this->confirmado | !$resultado) {
            self::$alertas['error'][] = "Contraseña incorrecta o tu cuenta no esta confirmada";
        } else {
            return true;
        }
    }

    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = "El password es obligatorio";
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "El password debe tener almenos 6 caracteres";
        }

        return self::$alertas;
    }
}
