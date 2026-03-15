<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController
{
    public static function index()
    {
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    public static function guardar()
    {
        $cita = new Cita($_POST);

        // guardar la citay devuelve el id
        $resultado = $cita->guardar();
        $id = $resultado['id'];

        // almacena la cita y los servicios
        $idServicios = explode(',', $_POST['servicios']);

        // por cada servicio en la cita, se debe guardar en la bd
        foreach ($idServicios as $idServicio) {
            $args = [
                "citaId" => $id,
                "servicioId" => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        };

        echo json_encode([
            "resultado" => $resultado
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
