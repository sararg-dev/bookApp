<?php
session_start();
require_once "modelos/libro_modelo.php";

class Libro_controlador
{
    public $view;
    public $libroObj;

    public function __construct()
    {
        $this->view = "listado_libros";
        $this->libroObj = new Libro_modelo();
    }

    public function mostrar_vista()
    {
        return $this->view;
    }

    public function obtener_libros()
    {
        // Obtener el ID de usuario de la sesión
        $user_id = $_SESSION['user_id'];

        // Tras llamar al modelo, devolvemos los libros del usuario indicado  
        $resultado = $this->libroObj->obtener_libros_usuario($user_id);

        return $resultado;
    }

    public function obtener_libro()
    {
        $this->view = 'libro_info';
    }

    public function obtener_libros_titulo()
    {
        if (isset($_POST['titulo'])) {
            // Obtenemos el ID del usuario de la sesión
            $user_id = $_SESSION['user_id'];

            $titulo = $_POST['titulo'];

            $resultado = $this->libroObj->obtener_libro_titulo($user_id, $titulo);

            // Manejar el resultado
            if ($resultado !== false) {
                return ['status' => 'success', 'resultado' => $resultado];
            } else {
                return ['status' => 'error', 'message' => 'Error al obtener el libro.'];
            }
        }

        return false;
    }

    public function guardar()
    {
        // Comprobamos que se obtienen los datos esperados
        if (isset($_POST['id_lista']) && isset($_POST['titulo']) && isset($_POST['autor']) && isset($_POST['descripcion']) && isset($_POST['portada']) && isset($_POST['idApi'])) {

            // Obtenemos los datos
            $user_id = $_SESSION['user_id'];
            $id_lista = $_POST['id_lista'];
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $descripcion = $_POST['descripcion'];
            $portada = $_POST['portada'];
            $idApi = $_POST['idApi'];

            $resultado = $this->libroObj->guardar_libro($user_id, $id_lista, $titulo, $autor, $descripcion, $portada, $idApi);

            // Manejar el resultado
            if ($resultado !== false) {
                return ['status' => 'success', 'resultado' => $resultado];
            } else {
                return ['status' => 'error', 'message' => 'Error al obtener el libro.'];
            }
        }
    }


    // Obtiene la lista a la que pertenece un libro
    public function obtener_lista()
    {
        $user_id = $_SESSION['user_id'];

        // Validar si se ha enviado el id_libro
        $id_libro = isset($_POST['id_libro']) ? $_POST['id_libro'] : null;

        // Obtener el nombre de la lista en función de los parámetros proporcionados
        $nombre_lista = $this->libroObj->obtener_libro_lista($user_id, $id_libro);

        // Manejar el resultado
        if ($nombre_lista !== false) {
            return ['status' => 'success', 'nombre_lista' => $nombre_lista];
        } else {
            return ['status' => 'error', 'message' => 'Error al obtener la lista del usuario.'];
        }
    }



    public function eliminar()
    {
        if (isset($_POST['id_libro'])) {
            // Obtenemos el ID del usuario de la sesión
            $user_id = $_SESSION['user_id'];

            $id_libro = $_POST['id_libro'];

            $resultado = $this->libroObj->eliminar_libro($user_id, $id_libro);

            if ($resultado) {
                return $resultado;
            }
        }

        return false;
    }
}
