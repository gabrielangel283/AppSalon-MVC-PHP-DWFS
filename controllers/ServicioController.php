<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    public static function index(Router $router)
    {

        isAdmin();

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'servicios' => $servicios
        ]);
    }

    public static function actualizar(Router $router)
    {
        isAdmin();

        $alertas = [];
        if (!is_numeric($_GET['id'])) return;

        $servicio = Servicio::find($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        };

        $router->render('servicios/actualizar', [
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }

    public static function crear(Router $router)
    {
        isAdmin();

        $servicio = new Servicio();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar()
    {
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            $servicio = Servicio::find($id);

            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}
