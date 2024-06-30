<?php

class Lista_modelo
{
    private $table = 'listas';
    private $conn;

    public function __construct()
    {
        $db = new Conectar();
        $this->conn = $db->getConnection();
    }

    // Obtenemos TODAS las listas del usuario
    public function obtener_listas_usuario($user_id)
    {

        $query = "SELECT * FROM " . $this->table . " WHERE id_usuario = :id_usuario";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $user_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $stmt->fetchAll();

        return $resultados;
    }
    
    // Obtenemos listas por su nombre 
    public function obtener_lista_nombre($user_id, $nombre_lista)
    {
        if (is_null($nombre_lista)) return false;

        $query = "SELECT * FROM " . $this->table . " WHERE id_usuario = :user_id AND nombre LIKE :nombre_lista";

        $nombre_lista = '%' . $nombre_lista . '%';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':nombre_lista', $nombre_lista);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $stmt->fetchAll(); // Cambiar a fetchAll()

        return $resultados;
    }

    // Obtenemos los libros que pertenecen a una lista
    public function obtener_contenido_lista($user_id, $id_lista)
    {
        $query = "SELECT listas.id AS lista_id, listas.nombre AS lista_nombre, libros_listas.id AS relacion_id, libros.id AS libro_id, libros.titulo AS libro_titulo, libros.autor AS libro_autor, libros.descripcion AS libro_descripcion, libros.portada AS libro_portada, libros.idApi AS idApi FROM listas LEFT JOIN libros_listas ON listas.id = libros_listas.id_lista LEFT JOIN libros ON libros_listas.id_libro = libros.id WHERE listas.id_usuario = :user_id AND listas.id = :id_lista ORDER BY listas.id, libros.titulo";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_lista', $id_lista);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function crear_lista_usuario($user_id, $nombre_lista)
    {
        $lista = ucfirst(strtolower($nombre_lista));

        // Comprobamos si existe una lista con el mismo nombre
        $result = $this->obtener_lista_nombre($user_id, $lista);

        if ($result) {
            return "Ya existe una lista con el mismo nombre";
        } else {

            $query = "INSERT INTO " . $this->table . " (nombre, id_usuario) VALUES (:lista, :user_id)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':lista', $lista);
            $stmt->bindParam(':user_id', $user_id);

            $stmt->execute();

            return $this->conn->lastInsertId();
        }
    }

    public function actualizar_lista_usuario($user_id, $id_lista, $nombre_lista)
    {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre_lista WHERE id_usuario = :user_id AND id = :id_lista";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_lista', $nombre_lista);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':id_lista', $id_lista);

        return $stmt->execute();
    }


    public function eliminar_lista_id($user_id, $id_lista)
    {
        // Iniciar una transacción para garantizar la atomicidad de las operaciones
        $this->conn->beginTransaction();

        try {
            // Consultar si hay libros asociados a la lista que se quiere eliminar
            $query_libros = "SELECT id_libro FROM libros_listas WHERE id_lista = :id_lista";
            $stmt_libros = $this->conn->prepare($query_libros);
            $stmt_libros->bindParam(':id_lista', $id_lista);
            $stmt_libros->execute();
            $libros_asociados = $stmt_libros->fetchAll(PDO::FETCH_COLUMN);

            // Si hay libros asociados, eliminar los registros de la tabla libros_listas
            if (!empty($libros_asociados)) {
                $query_eliminar_libros_lista = "DELETE FROM libros_listas WHERE id_lista = :id_lista";
                $stmt_eliminar_libros_lista = $this->conn->prepare($query_eliminar_libros_lista);
                $stmt_eliminar_libros_lista->bindParam(':id_lista', $id_lista);
                $stmt_eliminar_libros_lista->execute();

                // Eliminar los libros asociados de la tabla libros
                $query_eliminar_libros = "DELETE FROM libros WHERE id IN (" . implode(',', $libros_asociados) . ")";
                $stmt_eliminar_libros = $this->conn->prepare($query_eliminar_libros);
                $stmt_eliminar_libros->execute();
            }

            // Eliminar la lista de la tabla listas
            $query_eliminar_lista = "DELETE FROM " . $this->table . " WHERE id_usuario = :user_id AND id = :id_lista";
            $stmt_eliminar_lista = $this->conn->prepare($query_eliminar_lista);
            $stmt_eliminar_lista->bindParam(':user_id', $user_id);
            $stmt_eliminar_lista->bindParam(':id_lista', $id_lista);
            $stmt_eliminar_lista->execute();

            // Confirmar la transacción
            $this->conn->commit();

            return true; // Operación completada con éxito
        } catch (PDOException $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollBack();
            return false; // Ocurrió un error
        }
    }


    public function eliminar_listas_usuario($user_id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_usuario = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }
}
