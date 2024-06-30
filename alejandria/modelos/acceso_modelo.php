<?php

class Acceso_modelo
{
    private $table = 'usuarios';
    private $conn;

    public function __construct()
    {
        $db = new Conectar();
        $this->conn = $db->getConnection();
    }

    public function iniciar_sesion_usuario($email, $clave)
    {
        // Buscamos el email en la base de datos
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Si se encuentra el email, se verifica la contraseña
        if ($stmt->rowCount() > 0) {

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($clave, $usuario['clave'])) {

                // Si la contraseña es correcta, devolvemos el id del usuario
                return $usuario['id'];
            }
        }

        return false;
    }

    public function registrar_usuario($nombre_usuario, $email, $clave)
    {
        // Verificamos si el email ya está registrado
        $email_query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE email = :email";
        $email_stmt = $this->conn->prepare($email_query);
        $email_stmt->bindParam(':email', $email);
        $email_stmt->execute();
        // Guardamos el resultado de la consulta
        $resultado = $email_stmt->fetch(PDO::FETCH_ASSOC);

        // Si el resultado es > 0, entonces el usuario ya está registrado
        if ($resultado['total'] > 0) {
            return "Este email ya se encuentra registrado";
        }

        // Ciframos la clave del usuario antes de guardarla
        $hashed_clave = password_hash($clave, PASSWORD_DEFAULT);

        // Preparamos la consulta SQL
        $query = "INSERT INTO " . $this->table . " (nombre, email, clave, fecha) VALUES (:nombre_usuario, :email, :clave, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':clave', $hashed_clave);

        // Ejecutamos la consulta
        try {

            $stmt->execute();

            // Obtener el ID del usuario recién creado
            $usuario_id = $this->conn->lastInsertId();

            // Crear listas por defecto al registrar un usuario
            $listas_por_defecto = ['Libros pendientes', 'Libros leídos', 'Mis libros favoritos'];
            $lista_query = "INSERT INTO Listas (Nombre, id_usuario) VALUES (:nombre_lista, :id_usuario)";
            $lista_stmt = $this->conn->prepare($lista_query);

            foreach ($listas_por_defecto as $lista) {
                $lista_stmt->bindParam(':nombre_lista', $lista);
                $lista_stmt->bindParam(':id_usuario', $usuario_id);
                $lista_stmt->execute();
            }
            return true;
        } catch (PDOException $e) {

            // Comprobamos que el email no está duplicado
            if ($e->errorInfo[1] == 1062) {

                return "Error al crear la cuenta, por favor, vuelva a intentarlo";
            } else {

                throw $e;
            }
        }
    }

    public function eliminar_usuario($usuario_id)
    {
        // Comienza una transacción para asegurarse de que todas las operaciones se ejecuten de manera atómica
        $this->conn->beginTransaction();

        try {
            // Eliminar listas del usuario
            $query = "DELETE FROM listas WHERE id_usuario = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            // Eliminar libros asociados a las listas del usuario
            $query = "DELETE FROM libros_listas WHERE id_lista IN (SELECT id FROM listas WHERE id_usuario = :usuario_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            // Eliminar libros del usuario
            $query = "DELETE FROM libros WHERE id_usuario = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            // Eliminar valoraciones del usuario
            $query = "DELETE FROM valoraciones WHERE id_usuario = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            // Eliminar comentarios del usuario
            $query = "DELETE FROM comentarios WHERE id_usuario = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            // Eliminar el usuario
            $query = "DELETE FROM usuarios WHERE id = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            // Si todas las eliminaciones son exitosas, se confirma la transacción
            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            // Si hay un error, se revierte la transacción
            $this->conn->rollBack();

            // Manejar el error (opcionalmente puedes lanzar una excepción o registrar el error)
            return false;
        }
    }

    public function actualizar_usuario($id, $nombre, $clave, $foto)
    {
        try {
            $query = "UPDATE " . $this->table . " SET nombre = :nombre, clave = :clave, foto = :foto WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            // Encriptar la contraseña antes de guardarla
            $hashed_password = password_hash($clave, PASSWORD_BCRYPT);

            // Asignar los valores a los parámetros
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':clave', $hashed_password);
            $stmt->bindParam(':foto', $foto);

            $resultado = $stmt->execute();

            return $resultado;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function verificar_clave($user_id, $clave_actual)
    {
        // Preparar la consulta SQL para obtener la contraseña actual del usuario
        $query = "SELECT clave FROM " . $this->table . " WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener la contraseña actual del usuario
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $clave_hash = $row['clave'] ?? null;

        // Verificar si la contraseña actual coincide con la proporcionada
        if ($clave_hash && password_verify($clave_actual, $clave_hash)) {
            return true; // La contraseña actual es correcta
        } else {
            return false; // La contraseña actual es incorrecta
        }
    }



    // Consulta para obtener los datos del usuario por su ID
    public function obtener_datos_usuario($user_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function obtener_foto_usuario($user_id)
    {
        $query = "SELECT foto FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['foto']; // Devolver solo la ruta de la foto
        } else {
            return null; // Devolver null si no se encuentra ninguna foto
        }
    }
}
