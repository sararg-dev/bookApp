<?php
session_start();
require_once "modelos/lista_modelo.php";

class Lista_controlador
{

    public $view;
    public $listaObj;

    public function __construct()
    {
        $this->view = "inicio";
        $this->listaObj = new Lista_modelo();
    }

    public function mostrar_vista()
    {
        return $this->view;
    }

    public function obtener_contenido()
    {
        $this->view = 'lista_contenido';

        if (isset($_POST["id_lista"])) {

            $id_lista = $_POST["id_lista"];

            $user_id = $_SESSION['user_id'];

            $resultado = $this->listaObj->obtener_contenido_lista($user_id, $id_lista);

            if ($resultado) {
                return $resultado;
            } 
        }
    }

    public function obtener_listas()
    {
        // Obtener el ID de usuario de la sesión
        $user_id = $_SESSION['user_id'];

        // Tras llamar al modelo, devolvemos las listas del usuario indicado  
        $resultado = $this->listaObj->obtener_listas_usuario($user_id);

        return $resultado;
    }

    public function obtener_lista_nombre()
    {
        if (isset($_POST['nombre_lista'])) {
            // Obtener el ID de usuario de la sesión
            $user_id = $_SESSION['user_id'];

            // Obtenemos el id de la lista que se quiere obtener
            $nombre_lista = $_POST['nombre_lista'];

            $resultado = $this->listaObj->obtener_lista_nombre($user_id, $nombre_lista);

            return ($resultado);
        }
    }

    public function crear()
    {
        if (!empty($_POST['nombre_lista']) && trim($_POST['nombre_lista']) !== '') {
            // Obtenemos el ID del usuario de la sesión
            $user_id = $_SESSION['user_id'];

            $nombre_lista = $_POST['nombre_lista'];

            $resultado = $this->listaObj->crear_lista_usuario($user_id, $nombre_lista);

            return $resultado;
        }

        return false;
    }

    public function actualizar()
    {
        if (!empty($_POST['nombre_lista']) && trim($_POST['nombre_lista']) !== ''){
            // Obtenemos el ID del usuario de la sesión
            $user_id = $_SESSION['user_id'];

            // Obtenemos el id de la lista que se quiere modificar
            $id_lista = $_POST['id_lista'];

            // Obtenemos el nuevo nombre
            $nombre_lista = $_POST['nombre_lista'];

            $resultado = $this->listaObj->actualizar_lista_usuario($user_id, $id_lista, $nombre_lista);

            return $resultado;
        } 
        return false;
    }

    public function eliminar()
    {
        if (isset($_POST['id_lista'])) {
            // Obtenemos el ID del usuario de la sesión
            $user_id = $_SESSION['user_id'];

            $id_lista = $_POST['id_lista'];

            $resultado = $this->listaObj->eliminar_lista_id($user_id, $id_lista);

            if ($resultado) {
                return $resultado;
            }
        }

        return false;
    }

}
