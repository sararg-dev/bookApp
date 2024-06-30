<?php
session_start();
require_once "modelos/comentario_modelo.php";

class Comentario_controlador
{
    public $view;
    public $comentarioObj;

    public function __construct()
    {
        $this->view = "comentario_crear";
        $this->comentarioObj = new Comentario_modelo();
    }

    public function mostrar_vista()
    {
        return $this->view;
    }

    public function obtener_comentarios()
    {
        $user_id = $_SESSION['user_id'];
    
        // Validar si se ha enviado el id_libro
        $id_libro = isset($_POST['id_libro']) ? $_POST['id_libro'] : null;
    
        // Obtener comentarios en función de los parámetros proporcionados
        $resultado = $this->comentarioObj->obtener($user_id, $id_libro);
    
        // Manejar el resultado
        if ($resultado) {
            return $resultado;
        } else {
            return false;
        }
    }
    

    // Devolvemos todos los comentarios de un libro escritos por cualquier usuario
    public function obtener_comentarios_libro()
    {
        if (isset($_POST['idApi'])) {

            $idApi = $_POST['idApi'];

            $resultado = $this->comentarioObj->obtener_comentarios_libro($idApi);

            if ($resultado) {
                return $resultado;
            }
        }

        return false;
    }

    public function guardar()
    {
        // Comprobamos que se obtienen los datos esperados
        if (isset($_POST['id_libro']) && isset($_POST['contenido'])) {

            // Obtenemos los datos
            $user_id = $_SESSION['user_id'];
            $id_libro = $_POST['id_libro'];
            $contenido = $_POST['contenido'];

            $resultado = $this->comentarioObj->guardar($user_id, $id_libro, $contenido);

            if ($resultado) {
                return $resultado;
            }
        }
        return false;
    }

    public function actualizar()
    {
        // Comprobamos que se obtienen los datos esperados
        if (isset($_POST['id_libro']) && isset($_POST['id_comentario']) && isset($_POST['nuevo_contenido'])) {

            // Obtenemos los datos
            $user_id = $_SESSION['user_id'];
            $id_comentario = $_POST['id_comentario'];
            $nuevo_contenido = $_POST['nuevo_contenido'];

            $resultado = $this->comentarioObj->actualizar($user_id, $id_comentario, $nuevo_contenido);

            if ($resultado) {
                return $resultado;
            }
            return false;
        }
        return false;
    }

    public function eliminar()
    {
        if (isset($_POST['id_comentario'])) {

            $user_id = $_SESSION['user_id'];

            $id_comentario = $_POST['id_comentario'];

            $resultado = $this->comentarioObj->eliminar($user_id, $id_comentario);

            if ($resultado) {
                return $resultado;
            }
        }

        return false;
    }
}
