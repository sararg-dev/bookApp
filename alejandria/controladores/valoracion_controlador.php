<?php
session_start();
require_once "modelos/valoracion_modelo.php";

class Valoracion_controlador
{

    public $view;
    public $valoracionObj;

    public function __construct()
    {
        /* $this->view = "inicio"; */
        $this->valoracionObj = new Valoracion_modelo();
    }

    public function obtener()
    {
         // Comprobamos que se obtienen los datos esperados
         if (isset($_POST['id_libro'])) {

            // Obtenemos los datos
            $user_id = $_SESSION['user_id'];
            $id_libro = $_POST['id_libro'];

            $resultado = $this->valoracionObj->obtener($id_libro, $user_id);
            
            return $resultado;
        }
        return false;

    }

    public function guardar()
    {
        // Comprobamos que se obtienen los datos esperados
        if (isset($_POST['id_libro']) && isset($_POST['valoracion'])) {

            // Obtenemos los datos
            $user_id = $_SESSION['user_id'];
            $id_libro = $_POST['id_libro'];
            $valoracion = $_POST['valoracion'];

            $resultado = $this->valoracionObj->guardar($id_libro, $user_id, $valoracion);

            if ($resultado) {
                return $resultado;
            }
            return false;
        }
    }

    public function actualizar()
    {
        // Comprobamos que se obtienen los datos esperados
        if (isset($_POST['valoracion_id']) && isset($_POST['valoracion'])) {

            // Obtenemos los datos
            $user_id = $_SESSION['user_id'];
            $valoracion_id = $_POST['valoracion_id'];
            $valoracion = $_POST['valoracion'];

            $resultado = $this->valoracionObj->actualizar($valoracion_id, $valoracion, $user_id);

            if ($resultado) {
                return $resultado;
            }
            return false;
        }
    }

}
