/* 
    Función para obtener los datos del usuario
*/
export function obtener_datos_usuario() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=acceso_controlador&action=obtener_datos",
      method: "GET",
      success: function (data) {
        if (data) {
          resolve(data);
        } else {
          reject("Error al cargar los datos del usuario.");
        }
      },
      error: function () {
        reject("Error al realizar la solicitud.");
      },
    });
  });
}
/* 
    Función para obtener las listas del usuario
*/
export function obtener_listas() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=lista_controlador&action=obtener_listas",
      method: "GET",
      success: function (data) {
        if (data) {
          resolve(data);
        } else {
          reject("Error al cargar las listas del usuario.");
        }
      },
      error: function () {
        reject("Error al realizar la solicitud.");
      },
    });
  });
}
/* 
    Función para modificar el nombre de una lista
*/
export function actualizar_lista(id_lista, nombre_lista) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=lista_controlador&action=actualizar",
      method: "POST",
      data: {id_lista: id_lista, nombre_lista: nombre_lista},
      success: function (data) {
        if (data) {
          resolve(data);
        } else {
          reject("Error al modificar el nombre de la lista.");
        }
      },
      error: function () {
        reject("Error al realizar la solicitud.");
      },
    });
  });
}
/* 
    Función para eliminar una lista
*/
export function eliminar_lista(id_lista) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=lista_controlador&action=eliminar",
      method: "POST",
      data: {id_lista: id_lista},
      success: function (data) {
        if (data) {
          resolve(data);
        } else {
          reject("Error al eliminar la lista.");
        }
      },
      error: function () {
        reject("Error al realizar la solicitud.");
      },
    });
  });
}
/* 
    Función para actualizar los datos del usuario
*/
export function actualizar_datos(formData) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=acceso_controlador&action=actualizar",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          resolve(response.message || "Perfil actualizado correctamente.");
        } else {
          reject(response.message || "Error al actualizar el perfil.");
        }
      },
      error: function () {
        reject("Error al realizar la solicitud.");
      },
    });
  });
}
/* 
    Función para eliminar una lista
*/
export function crear_lista(nombre_lista) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=lista_controlador&action=crear",
      method: "POST",
      data: {nombre_lista: nombre_lista},
      success: function (data) {
        if (data) {
          resolve(data);
        } else {
          reject("Error al crear la lista.");
        }
      },
      error: function () {
        reject("Error al realizar la solicitud.");
      },
    });
  });
}
/* 
    Función para obtener el contenido de una lista de lectura
*/
export function obtener_contenido_lista(id_lista) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=lista_controlador&action=obtener_contenido",
      method: "POST",
      data: { id_lista: id_lista },
      success: function (response) {
        if (response) {
          console.log("contenido: " + response);
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para obtener los libros del usuario
*/
export function obtener_libros_usuario() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=libro_controlador&action=obtener_libros",
      method: "GET",
      success: function (response) {
        if (response) {
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para obtener a qué lista pertenece un libro
*/
export function obtener_lista(id_libro) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=libro_controlador&action=obtener_lista",
      method: "POST",
      data: { id_libro: id_libro },
      success: function (response) {
        if (response.status === 'success') {
          resolve(response.nombre_lista);
        } else {
          reject(response.message);
        }
      },
      error: function (xhr, status, error) {
        reject(error);
      },
    });
  });
}

/* 
    Función para obtener todos los comentarios de un usuario sobre un libro
*/
export function obtener_comentarios(id_libro) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=comentario_controlador&action=obtener_comentarios",
      method: "POST",
      data: { id_libro: id_libro },
      success: function (response) {
        if (response) {
          resolve(response);
        } else {
          resolve([]); // Resolver con un array vacío si no hay comentarios
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para obtener los comentarios sobre un libro escrito por cualquier usuario
*/
export function obtener_comentarios_libro(idApi) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=comentario_controlador&action=obtener_comentarios_libro",
      method: "POST",
      data: { idApi: idApi },
      success: function (response) {
        if (response) {
          resolve(response);
        } else {
          resolve([]); // Resolver con un array vacío si no hay comentarios
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para guardar el comentario de un usuario sobre un libro
*/
export function guardar_comentario(id_libro, contenido) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=comentario_controlador&action=guardar",
      method: "POST",
      data: { id_libro: id_libro, contenido: contenido },
      success: function (response) {
        if (response) {
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para eliminar un comentario
*/
export function eliminar_comentario(id_comentario) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=comentario_controlador&action=eliminar",
      method: "POST",
      data: { id_comentario: id_comentario },
      success: function (response) {
        if (response) {
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para buscar un libro por título en libros
*/
export function buscar_libro(titulo) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=libro_controlador&action=obtener_libros_titulo",
      method: "POST",
      data: { titulo: titulo },
      success: function (response) {
        if (response.status === 'success') {
          resolve(response.resultado);
        } else {
          reject(response.message);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para eliminar un libro
*/
export function eliminar_libro(id_libro) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=libro_controlador&action=eliminar",
      method: "POST",
      data: { id_libro: id_libro },
      success: function (response) {
        if (response) {
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para guardar un libro
*/
export function guardar_libro(book, listaId) {
  console.log("En la función guardar_libro"); 
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=libro_controlador&action=guardar",
      method: "POST",
      data: {
        id_lista: listaId,
        titulo: book.volumeInfo.title,
        autor: book.volumeInfo.authors ? book.volumeInfo.authors.join(", ") : "Autor desconocido",
        descripcion: book.volumeInfo.description ? book.volumeInfo.description : "No disponible",
        portada: book.volumeInfo.imageLinks ? book.volumeInfo.imageLinks.thumbnail : "https://via.placeholder.com/128x196?text=No+disponible",
        idApi: book.id
      },
      success: function (response) {
        if (response.status === 'success') {
          resolve(response.resultado);
        } else {
          reject(response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", status, error);
        console.error("Detalle del error:", xhr.responseText);
        reject(error);
      }
    });
  });
}
/* 
    Función para obtener la valoración de un usuario sobre un libro
*/
export function obtener_valoracion(id_libro) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=valoracion_controlador&action=obtener",
      method: "POST",
      data: { id_libro: id_libro },
      success: function (response) {
        if (response) {
          resolve(response);
        } else {
          resolve(0);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para guardar la valoración de un usuario sobre un libro
*/
export function guardar_valoracion(id_libro, valoracion) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=valoracion_controlador&action=guardar",
      method: "POST",
      data: { id_libro: id_libro, valoracion: valoracion },
      success: function (response) {
        if (response) {
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}

/* 
    Función para actualizar la valoración de un usuario sobre un libro
*/
export function actualizar_valoracion(valoracion_id, valoracion) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "index.php?controller=valoracion_controlador&action=actualizar",
      method: "POST",
      data: { valoracion_id: valoracion_id, valoracion: valoracion },
      success: function (response) {
        if (response) {
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
/* 
    Función para obtener la información de un libro
*/
export function obtener_libro_info(idApi) {
  return new Promise((resolve, reject) => {
    var url =
      "https://www.googleapis.com/books/v1/volumes/" +
      idApi +
      "?key=AIzaSyDpgUD-BMi-S5nxL6AqWmA6soOs2-Qj2V8";

    $.ajax({
      url: url,
      method: "GET",
      success: function (response) {
        if (response) {
          resolve(response);
        }
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
