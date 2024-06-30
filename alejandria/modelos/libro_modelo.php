<?php

class Libro_modelo
{
    private $table = 'libros';
    private $conn;

    public function __construct()
    {
        $db = new Conectar();
        $this->conn = $db->getConnection();
    }

    public function obtener_libros_usuario($user_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_usuario = :user_id ORDER BY fechaCreacion DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $stmt->fetchAll();

        return $resultados;
    }


    public function obtener_libro_titulo($user_id, $titulo)
    {
        if (is_null($titulo)) return false;

        $query = "SELECT * FROM " . $this->table . " WHERE id_usuario = :user_id AND titulo LIKE :titulo";

        $titulo = '%' . $titulo . '%';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $stmt->fetchAll();

        return $resultados;
    }

    // Obtiene la lista a la que pertenece un libro
    public function obtener_libro_lista($user_id, $id_libro)
    {
        if (is_null($id_libro)) return false;

        $query = " SELECT l.nombre AS nombre_lista FROM libros_listas ll JOIN listas l ON ll.id_lista = l.id WHERE ll.id_libro = :id_libro AND l.id_usuario = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':id_libro', $id_libro);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $stmt->fetch();

        return $resultados;
    }

    public function guardar_libro($user_id, $id_lista, $titulo, $autor, $descripcion, $portada, $idApi)
    {
        $this->conn->beginTransaction();

        try {
            $query = "INSERT INTO " . $this->table . " (titulo, autor, descripcion, portada, idApi, id_usuario) VALUES (:titulo, :autor, :descripcion, :portada, :idApi, :user_id)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':portada', $portada);
            $stmt->bindParam(':idApi', $idApi);
            $stmt->bindParam(':user_id', $user_id);

            $stmt->execute();

            $libroId = $this->conn->lastInsertId();

            $query2 = "INSERT INTO  libros_listas (id_lista, id_libro, id_usuario) VALUES (:id_lista, :id_libro, :user_id)";

            $stmt = $this->conn->prepare($query2);
            $stmt->bindParam(':id_lista', $id_lista);
            $stmt->bindParam(':id_libro', $libroId);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Confirmar la transacción
            $this->conn->commit();
            return true; // Operación completada con éxito

        } catch (PDOException $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollBack();
            return false; // Ocurrió un error
        }
    }

    public function eliminar_libro($user_id, $id_libro)
    {
        $this->conn->beginTransaction();

        try {
            // Eliminamos las relaciones del libro en la tabla comentarios
            $query = "DELETE FROM comentarios WHERE id_libro = :id_libro";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->execute();

            // Eliminamos las relaciones del libro en la tabla valoraciones
            $query = "DELETE FROM valoraciones WHERE id_libro = :id_libro";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->execute();

            // Eliminamos las relaciones del libro en la tabla libros_listas
            $query = "DELETE FROM libros_listas WHERE id_libro = :id_libro AND id_usuario = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Eliminamos el libro de la tabla libros
            $query = "DELETE FROM " . $this->table . " WHERE id = :id_libro AND id_usuario = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Confirmar la transacción
            $this->conn->commit();

            return true; // Operación completada con éxito

        } catch (PDOException $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollBack();
            return false; // Ocurrió un error
        }
    }

    // Obtener promedio de valoraciones de un libro
    public function obtener_promedio_valoraciones($libro_id)
    {
        $query = "SELECT AVG(v.valoracion) AS promedio_valoracion
                  FROM valoraciones v
                  WHERE v.id_libro = :libro_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':libro_id', $libro_id, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el resultado es nulo, retorna 0 como promedio de valoraciones.
        if ($resultado && isset($resultado['promedio_valoracion'])) {
            return (float)$resultado['promedio_valoracion'];
        } else {
            return 0.0;
        }
    }
}
