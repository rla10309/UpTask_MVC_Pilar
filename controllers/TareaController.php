<?php

namespace Controllers;

use Model\Tarea;
use Model\Proyecto;



class TareaController {

    public static function index() {
        session_start();

        $proyectoId = $_GET["url"];

        if(!$proyectoId) header("Location: /dashboard");

        $proyecto = Proyecto::where("url", $proyectoId);

        if(!$proyecto || $proyecto->propietarioId !== $_SESSION["id"]){
            header("Location: /404");
        }
        $tareas = Tarea::belongsTo("proyectoId", $proyecto->id);

       echo json_encode(["tareas" => $tareas]);
    }
    
    public static function crear() {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            session_start();

            $proyecto = Proyecto::where("url", $_POST["proyectoId"]);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION["id"]) {
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un error al agregar la tarea"
                ];
                echo json_encode($respuesta);
                return;
            }

            // OK. Instanciar y crear la tarea
            $tarea = new Tarea($_POST);


            $tarea->proyectoId = $proyecto->id;

            $resultado = $tarea->guardar();

            $respuesta = [
                "tipo"=>"exito",
                "id"=>$resultado["id"],
                "mensaje" => "Tarea creada correctamente"
            ];

            echo json_encode($respuesta);
        }
    }
    public static function actualizar() {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        }
    }

    public static function eliminar() {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        }
    }
}
