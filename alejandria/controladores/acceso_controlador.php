<?php
session_start();
require_once "modelos/acceso_modelo.php";

class Acceso_controlador
{
    public $view;
    private $usuario;

    public function __construct()
    {
        $this->view = "login";
        $this->usuario = new Acceso_modelo(); // Creamos una instancia de modelo Acceso_modelo
    }

    public function mostrar_vista()
    {
        return $this->view;
    }

    public function mostrar_configuracion()
    {
        return $this->view = 'configuracion';
    }

    public function mostrar_terminos()
    {
        return $this->view = 'terminos';
    }

    public function iniciar_sesion($email = null, $clave = null)
    {
        $data = array("data" => array());

        // Si se han introducido datos, llamamos al modelo y los comprobamos
        if (isset($_POST['email']) && isset($_POST['clave'])) {

            // Obtenemos los valores de POST
            $email = $_POST['email'];
            $clave = $_POST['clave'];

            $user_id = $this->usuario->iniciar_sesion_usuario($email, $clave);

            if ($user_id) {
                // Guarda el ID del usuario en la sesión
                $_SESSION['user_id'] = $user_id;
                // Si las credenciales son válidas, redirigir al usuario a la página de inicio
                header('Location: index.php?controller=lista_controlador&action=mostrar_vista');
                exit; // Detener la ejecución del script después de la redirección
            } else {
                // Si las credenciales son incorrectas, establecemos el mensaje de error
                $data["data"]["error_message"] = "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
            }
        }

        return $data;
    }

    public function registrar($nombre_usuario = null, $email = null, $clave = null)
    {
        $this->view = 'registro';
        $data = array("data" => array());

        // Si se han introducido datos, llamamos al modelo y los comprobamos
        if (isset($_POST['nombre_usuario']) && isset($_POST['email']) && isset($_POST['clave'])) {

            // Obtenemos los valores de POST
            $nombre_usuario = $_POST['nombre_usuario'];
            $email = $_POST['email'];
            $clave = $_POST['clave'];

            $resultado = $this->usuario->registrar_usuario($nombre_usuario, $email, $clave);

            if ($resultado) {
                header('Location: index.php?controller=acceso_controlador&action=mostrar_vista&mensaje_exitoso=1');
                exit; // Detener la ejecución del script después de la redirección
            } else {
                // Si hay un error en el registro, establecer el mensaje de error
                $data["data"]["error_message"] = "Error al crear la cuenta. Por favor, inténtelo de nuevo.";
            }
        }

        return $data;
    }


    public function cerrar_sesion()
    {
        // Limpiar la variable de sesión
        session_unset();

        // Destruir la sesión
        session_destroy();

        // Redirigir al usuario a la página de inicio de sesión
        header('Location: index.php?');
        exit; // Detener la ejecución del script después de la redirección
    }


    public function eliminar()
    {  
        return $this->view = 'adios';
    }

    public function actualizar()
    {
        $this->view = 'configuracion';

        $data = array("data" => array());
        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario
            $nombre = $_POST['nombre'] ?? '';
            $claveActual = $_POST['claveActual'] ?? '';
            $nuevaClave = $_POST['nuevaClave'] ?? '';

            // Verificar si se ha subido una nueva foto
            if (isset($_FILES['cambiar_foto']) && $_FILES['cambiar_foto']['error'] === UPLOAD_ERR_OK) {
                $foto_temp = $_FILES['cambiar_foto']['tmp_name'];
                $foto_nombre = $_FILES['cambiar_foto']['name'];
                $foto_extension = pathinfo($foto_nombre, PATHINFO_EXTENSION);
                $foto_destino = 'uploads/' . $user_id . '.' . $foto_extension;
                move_uploaded_file($foto_temp, $foto_destino);
                $foto = $foto_destino;
            } else {
                // Si no se ha subido una nueva foto, obtener la ruta de la foto actual del usuario
                $foto_actual = $this->usuario->obtener_foto_usuario($user_id);
                $foto = $foto_actual ? $foto_actual : null;
            }

            // Verificar la clave actual
            if (!$this->usuario->verificar_clave($user_id, $claveActual)) {
                $data["data"]["error_message"] = "La contraseña actual no es correcta. Por favor, ingresa tu contraseña actual.";
            } else {
                // Actualizar los datos del usuario
                $clave = $nuevaClave ? $nuevaClave : $claveActual; // Usar la nueva clave si se proporciona, si no usar la actual
                $resultado = $this->usuario->actualizar_usuario($user_id, $nombre, $clave, $foto);

                if ($resultado) {
                    $data["data"]["mensaje_exitoso"] = "¡Cambios guardados correctamente!";
                } else {
                    $data["data"]["error_message"] = "Error al realizar los cambios. Por favor, vuelva a intentarlo.";
                }
            }
        }

        return $data;
    }


    public function obtener_datos()
    {
        // Obtener el ID de usuario de la sesión
        $user_id = $_SESSION['user_id'];


        $resultado = $this->usuario->obtener_datos_usuario($user_id);

        if ($resultado) {
            return $resultado;
        }

        return false;
    }
}
