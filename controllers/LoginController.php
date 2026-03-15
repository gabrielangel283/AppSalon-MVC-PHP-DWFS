<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController
{

    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    // verificar el password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // autenticar el usuario

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // redireccionamiento
                        if ($usuario->admin == 1) {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('eror', "Usuario no encontrado");
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            "alertas" => $alertas
        ]);
    }

    public static function logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        };

        $_SESSION = [];

        header('Location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado == "1") {
                    // generar un token
                    $usuario->crearToken();
                    $usuario->guardar();

                    // enviar el email
                    Usuario::setAlerta('exito', 'Revisa tu email');

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarIntricciones();
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
            $alertas = Usuario::getAlertas();
        }

        $router->render('auth/olvide-password', [
            "alertas" => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];

        $error = false;

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // leer el nuevo password y guardarlo

            $password = new Usuario($_POST);

            $alertas = $password->validarPassword();

            if (empty($alertas)) {
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            "alertas" => $alertas,
            "error" => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario($_POST);

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            // revisar alertas
            if (empty($alertas)) {

                // verificar si el usuario existe
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // proceso de guardar nuevo usuario

                    // hashear la contraseña
                    $usuario->hashPassword();

                    // generar el token de confirmacion
                    $usuario->crearToken();

                    // enviar el email de confirmacion
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // crear el usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: \mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function confirmar(Router $router)
    {

        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);


        if (empty($usuario)) {
            // mostrar mensaje de error
            Usuario::setAlerta('Error', 'Token no valido');
        } else {
            // modificar al usuario confirmado
            $usuario->confirmado = "1";

            $usuario->token = null;

            $usuario->guardar();

            Usuario::setAlerta('exito', "Cuenta confirmado correctamente");
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {

        $router->render("auth/mensaje", []);
    }
}
