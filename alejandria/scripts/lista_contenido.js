import {
  obtener_contenido_lista,
  actualizar_lista,
  eliminar_lista,
  obtener_comentarios,
  eliminar_libro,
  obtener_valoracion,
  guardar_valoracion,
  actualizar_valoracion,
  guardar_comentario,
  eliminar_comentario,
} from "./ajax.js";

$(document).ready(function () {
  // Obtenemos el id_lista de la URL
  var urlParams = new URLSearchParams(window.location.search);
  var id_lista = urlParams.get("id_lista");

  // Cargamos los libros del usuario al mostrar la vista
  obtener_contenido_lista(id_lista)
    .then(function (libros) {
      // Obtener el nombre de la lista del primer libro
      if (libros.length > 0) {
        $("#lista_titulo").text(libros[0].lista_nombre);
      }
      // Obtener detalles adicionales para cada libro
      var detallePromesas = libros.map((libro) => obtenerDetallesLibro(libro));
      return Promise.allSettled(detallePromesas);
    })
    .then(function (results) {
      const librosConDetalles = results
        .filter((result) => result.status === "fulfilled")
        .map((result) => result.value)
        .filter((libro) => libro !== null); // Filtramos los null que puedan haber
      // Mostrar los libros con las valoraciones obtenidas
      mostrar_contenido(librosConDetalles);
    })
    .catch(function (error) {
      console.error("Error el contenido de la lista:", error);
      $("#lista_contenido").html(
        "Error al buscar libros. Por favor, inténtalo de nuevo más tarde."
      );
    });

  // Abrir modal para editar el nombre de la lista
  $("#editar_lista").click(function () {
    var nombre_lista_actual = $("#lista_titulo").text();
    $("#nuevo_nombre_lista").val(nombre_lista_actual);
    $("#modal-editar-lista").modal("show");
  });

  // Guardar el nuevo nombre de la lista
  $("#guardar_nombre_lista").click(function () {
    var nuevoNombre = $("#nuevo_nombre_lista").val();
    if (nuevoNombre.trim() !== "") {
      actualizar_lista(id_lista, nuevoNombre)
        .then(function (data) {
          $("#lista_titulo").text(nuevoNombre);
          $("#modal-editar-lista").modal("hide");
          mostrarExito("Nombre de la lista actualizado con éxito.");
        })
        .catch(function (error) {
          console.error("Error al actualizar el nombre de la lista:", error);
        });
    } else {
      mostrarError("El nombre de la lista no puede estar vacío.");
    }
  });

  // Abrir modal para confirmar eliminación de la lista
  $("#eliminar_lista").click(function () {
    $("#modal-confirmar-eliminar-lista").modal("show");
  });

  // Confirmar eliminación de la lista
  $("#confirmar_eliminar_lista").click(function () {
    eliminar_lista(id_lista)
      .then(function (data) {
        window.location.href =
          "index.php?controller=lista_controlador&action=mostrar_vista";
      })
      .catch(function (error) {
        console.error("Error al eliminar la lista:", error);
      });
  });

  function obtenerDetallesLibro(libro) {
    const id_libro = libro.libro_id;
    return Promise.all([
      obtener_comentarios(id_libro),
      obtener_valoracion(id_libro),
    ])
      .then(function ([comentarios, valoracion]) {
        libro.comentarios =
          comentarios && comentarios.length > 0 ? comentarios : null;
        libro.valoracion =
          valoracion && valoracion.valoracion !== undefined
            ? valoracion.valoracion
            : 0;
        return libro; // Devolvemos el libro con los detalles actualizados
      })
      .catch(function (error) {
        // En lugar de devolver null, lanzamos un error para que se maneje correctamente
        throw new Error("Error al obtener los detalles del libro");
      });
  }

  function mostrar_contenido(libros) {
    // Seleccionamos el contenedor donde se mostrarán los libros
    var contenedor = $("#lista_contenido");

    // Limpiamos el contenido anterior del contenedor
    contenedor.empty();
    console.log("Librosid: " + libros.libro_id);
    // Verifica si hay libros
    if (libros[0].libro_id === null) {
      var libroHTML = `<div>No has agregado ningún libro a la lista.</div>`;
    } else {
      // Añadimos el encabezado
      var libroHTML = `
      <div class="book-row-header">
        <div class="book-details"><strong>Título</strong></div>
        <div class="book-author"><strong>Autor</strong></div>
        <div class="book-rating"><strong>Valoración</strong></div>
        <div class="book-review"><strong>Reseña</strong></div>
        <div class="book-actions"><strong>Acciones</strong></div>
      </div>
    `;
      // Iteramos sobre cada libro para generar su HTML y mostrarlo en el contenedor
      libros.forEach((libro) => {
        const comentariosBtn = libro.comentarios
          ? "Ver reseña"
          : "Escribir reseña";
        libroHTML += `
          <div class="book-row" data-libro-id="${libro.libro_id}">
            <div class="book-details">
              <a href="index.php?controller=libro_controlador&action=obtener_libro&idApi=${
                libro.idApi
              }&libro_id=${libro.libro_id}" class="nav-link">
                <img src="${
                  libro.libro_portada
                }" alt="Portada del libro" class="book-cover">
              </a>
              <div class="book-info">
                <a href="index.php?controller=libro_controlador&action=obtener_libro&idApi=${
                  libro.idApi
                }&libro_id=${libro.libro_id}" class="nav-link">
                  <h5>${libro.libro_titulo}</h5>
                </a>
              </div>
            </div>
            <div class="book-author">
              <p>${libro.libro_autor}</p>
            </div>
            <div class="book-rating">
              ${[1, 2, 3, 4, 5]
                .map(
                  (num) =>
                    `<i class="fa fa-star star ${
                      libro.valoracion >= num ? "checked" : ""
                    }" data-rating="${num}"></i>`
                )
                .join("")}
            </div>
             <div class="book-review">
                <button class="btn btn-general${
                  libro.comentarios ? "-ver-comentario" : " escribir-comentario"
                }" data-id="${libro.libro_id}" 
                  data-comentario-id="${
                    libro.comentarios ? libro.comentarios[0].id : ""
                  }" 
                  data-comentario="${
                    libro.comentarios ? libro.comentarios[0].contenido : ""
                  }">
                  ${comentariosBtn}
                </button>
            </div>
            <div class="book-actions" title="Eliminar">
              <i class="fa-solid fa-xmark fa-lg btn_eliminar" data-libro-id="${
                libro.libro_id
              }"></i>
            </div>
          </div>
        `;
      });
    }
    // Agregamos el elemento de lista al contenedor
    contenedor.append(libroHTML);

    // Agregar eventos a las estrellas y asegurarse de que estén coloreadas correctamente al iniciar
    libros.forEach((libro) => {
      mostrar_valoracion(libro.libro_id, libro.valoracion);
    });

    // Evento clic para abrir el modal de comentario
    $(document).on("click", ".escribir-comentario", function () {
      var id_libro = $(this).data("id"); // Obtener el ID del libro desde el botón
      $("#modal-comentario").data("id-libro", id_libro).modal("show");
    });

    // Evento clic para cerrar el modal
    $(document).on("click", ".close", function () {
      $(
        "#modal-comentario, #modal-ver-comentario, #modal-confirmacion-eliminar, #modal-confirmar-eliminar-lista, #modal-editar-lista, #modal-confirmacion-valoracion"
      ).modal("hide");
    });

    // Evento clic para guardar el comentario
    $(document).on("click", "#guardar-comentario-btn", function () {
      var contenido = $("#comentario-texto").val().trim();
      var id_libro = $("#modal-comentario").data("id-libro"); // Obtener el ID del libro guardado en el modal
      if (contenido === "") {
        mostrarError("¡La reseña no puede quedar vacía!");
      } else {
        guardar_comentario(id_libro, contenido)
          .then(function (response) {
            // Mensaje de éxito
            mostrarExito("Reseña guardada correctamente!.");
            // Cerrar el modal
            $("#modal-comentario").modal("hide");
            setTimeout(function () {
              // Cargamos los libros del usuario al mostrar la vista nuevamente
              obtener_contenido_lista(id_lista)
                .then(function (libros) {
                  console.log(libros);
                  // Obtener detalles adicionales para cada libro
                  var detallePromesas = libros.map((libro) =>
                    obtenerDetallesLibro(libro)
                  );
                  return Promise.allSettled(detallePromesas);
                })
                .then(function (results) {
                  const librosConDetalles = results
                    .filter((result) => result.status === "fulfilled")
                    .map((result) => result.value)
                    .filter((libro) => libro !== null); // Filtramos los null que puedan haber
                  // Mostrar los libros con las valoraciones obtenidas
                  mostrar_contenido(librosConDetalles);
                })
                .catch(function (error) {
                  console.error("Error el contenido de la lista:", error);
                  $("#lista_contenido").html(
                    "Error al buscar libros. Por favor, inténtalo de nuevo más tarde."
                  );
                });
            }, 2500);
          })
          .catch(function (error) {
            console.error("Error al guardar el comentario:", error);
          });
      }
    });

    // Evento clic para cerrar el modal
    $(document).on("click", "#modal-comentario", function (event) {
      if ($(event.target).hasClass("modal")) {
        $(this).modal("hide");
      }
    });
    // Agregamos el evento para poder eliminar un libro
    $(document).on("click", ".btn_eliminar", function () {
      var id_libro = $(this).data("libro-id");

      // Abrir el modal de confirmación para eliminar el libro
      $("#modal-confirmacion-eliminar").modal("show");

      // Guardar el ID del libro en un atributo de datos del modal
      $("#modal-confirmacion-eliminar").data("libro-id", id_libro);
    });

    // Evento para manejar la eliminación del libro cuando se confirma en el modal
    $("#confirmar-eliminar-btn").click(function () {
      var id_libro = $("#modal-confirmacion-eliminar").data("libro-id");

      // Llamamos a la función para eliminar el libro
      eliminar_libro(id_libro)
        .then((response) => {
          // Eliminamos la fila del libro del DOM después de eliminarlo del servidor
          $(".book-row[data-libro-id='" + id_libro + "']").remove();
          // Mostrar un alerta con el mensaje de éxito
          mostrarExito("Libro eliminado con éxito.");

          // Esperar 2500 milisegundos (2.5 segundos) antes de actualizar la página
          setTimeout(function () {
            // Cargamos los libros del usuario al mostrar la vista nuevamente
            obtener_contenido_lista(id_lista)
              .then(function (libros) {
                console.log(libros);
                // Obtener detalles adicionales para cada libro
                var detallePromesas = libros.map((libro) =>
                  obtenerDetallesLibro(libro)
                );
                return Promise.allSettled(detallePromesas);
              })
              .then(function (results) {
                const librosConDetalles = results
                  .filter((result) => result.status === "fulfilled")
                  .map((result) => result.value)
                  .filter((libro) => libro !== null); // Filtramos los null que puedan haber
                // Mostrar los libros con las valoraciones obtenidas
                mostrar_contenido(librosConDetalles);
              })
              .catch(function (error) {
                console.error("Error el contenido de la lista:", error);
                $("#lista_contenido").html(
                  "Error al buscar libros. Por favor, inténtalo de nuevo más tarde."
                );
              });
          }, 2500);
        })
        .catch((error) => {
          console.error("Error al eliminar el libro:", error);
        });

      // Cerrar el modal de confirmación
      $("#modal-confirmacion-eliminar").modal("hide");
    });

    $(document).on("click", ".btn-general-ver-comentario", function () {
      var comentario = $(this).data("comentario");
      var comentarioId = $(this).data("comentario-id");
      $("#contenido-comentario").text(comentario);
      $("#modal-ver-comentario")
        .data("comentario-id", comentarioId)
        .modal("show");
    });

    $(document).on("click", "#eliminar-comentario-btn", function () {
      var comentarioId = $("#modal-ver-comentario").data("comentario-id");
      eliminar_comentario(comentarioId)
        .then(function (response) {
          mostrarExito("Comentario eliminado correctamente.");
          $("#modal-ver-comentario").modal("hide");
          setTimeout(function () {
            // Cargamos los libros del usuario al mostrar la vista
            obtener_contenido_lista(id_lista)
              .then(function (libros) {
                // Obtener el nombre de la lista del primer libro
                if (libros.length > 0) {
                  $("#lista_titulo").text(libros[0].lista_nombre);
                }
                // Obtener detalles adicionales para cada libro
                var detallePromesas = libros.map((libro) =>
                  obtenerDetallesLibro(libro)
                );
                return Promise.allSettled(detallePromesas);
              })
              .then(function (results) {
                const librosConDetalles = results
                  .filter((result) => result.status === "fulfilled")
                  .map((result) => result.value)
                  .filter((libro) => libro !== null); // Filtramos los null que puedan haber
                // Mostrar los libros con las valoraciones obtenidas
                mostrar_contenido(librosConDetalles);
              })
              .catch(function (error) {
                console.error("Error el contenido de la lista:", error);
                $("#lista_contenido").html(
                  "Error al buscar libros. Por favor, inténtalo de nuevo más tarde."
                );
              });
          }, 2500);
        })
        .catch(function (error) {
          console.error("Error al eliminar el comentario:", error);
        });
    });

    // Agregar eventos a las estrellas
    $(document).on("click", ".star", function () {
      var valoracion = $(this).data("rating");
      var id_libro = $(this).closest(".book-row").data("libro-id");

      obtener_valoracion(id_libro)
        .then((valoracion_usuario) => {
          if (valoracion_usuario && valoracion_usuario.valoracion) {
            // Guardar los datos en el modal
            $("#modal-confirmacion-valoracion").data("id-libro", id_libro);
            $("#modal-confirmacion-valoracion").data("valoracion", valoracion);
            $("#modal-confirmacion-valoracion").data(
              "valoracion-usuario",
              valoracion_usuario.id
            );

            // Mostrar el modal
            $("#modal-confirmacion-valoracion").modal("show");
          } else {
            // El usuario no ha valorado el libro, por lo que guardamos una nueva valoración
            return guardar_valoracion(id_libro, valoracion).then(() => {
              mostrar_valoracion(id_libro, valoracion);
              destelloEstrellas(id_libro); // Añadir la animación de destello
            });
          }
        })
        .catch((error) => {
          console.error("Error al obtener la valoración del libro:", error);
        });
    });

    $(document).on("click", "#confirmar-cambio-valoracion-btn", function () {
      var id_libro = $("#modal-confirmacion-valoracion").data("id-libro");
      var valoracion = $("#modal-confirmacion-valoracion").data("valoracion");
      var valoracion_usuario_id = $("#modal-confirmacion-valoracion").data(
        "valoracion-usuario"
      );

      actualizar_valoracion(valoracion_usuario_id, valoracion)
        .then(() => {
          mostrar_valoracion(id_libro, valoracion);
          destelloEstrellas(id_libro); // Añadir la animación de destello
        })
        .catch((error) => {
          console.error("Error al actualizar la valoración del libro:", error);
        });

      // Cerrar el modal
      $("#modal-confirmacion-valoracion").modal("hide");
    });

    // Efectos estrellitas
    $(document).on("mouseenter", ".star", function () {
      var rating = $(this).data("rating");
      $(this)
        .siblings(".star")
        .each(function () {
          if ($(this).data("rating") <= rating) {
            $(this).addClass("hovered");
          }
        });
      $(this).addClass("hovered");
    });

    $(document).on("mouseleave", ".star", function () {
      $(this).siblings(".star").removeClass("hovered");
      $(this).removeClass("hovered");
    });
  }

  function mostrar_valoracion(id_libro, valoracion) {
    var estrellas = $(`.book-row[data-libro-id="${id_libro}"] .star`);
    estrellas.each(function () {
      var rating = $(this).data("rating");
      if (rating <= valoracion) {
        $(this).addClass("checked");
      } else {
        $(this).removeClass("checked");
      }
    });
  }

  function destelloEstrellas(id_libro) {
    var estrellas = $(`.book-row[data-libro-id="${id_libro}"] .star.checked`);
    estrellas.addClass("sparkle");
    setTimeout(function () {
      estrellas.removeClass("sparkle");
    }, 500); // Duración de la animación en milisegundos
  }

  function mostrarExito(mensaje) {
    var alertContainer = $("#alert-container");
    alertContainer.text(mensaje);
    alertContainer.removeClass("d-none alert-danger alert-warning alert-info"); // Asegúrate de eliminar otras clases de alerta
    alertContainer.addClass("alert-success");
    alertContainer.show(); // Muestra el contenedor de alerta

    // Ocultar la alerta después de 3 segundos
    setTimeout(function () {
      alertContainer.addClass("d-none");
      alertContainer.removeClass("alert-success"); // Elimina la clase alert-danger para futuras alertas
    }, 3000);
  }

  function mostrarError(mensaje) {
    var alertContainer = $("#alert-container");
    alertContainer.text(mensaje);
    alertContainer.removeClass("d-none alert-success alert-warning alert-info"); // Asegúrate de eliminar otras clases de alerta
    alertContainer.addClass("alert-danger");
    alertContainer.show(); // Muestra el contenedor de alerta

    // Ocultar la alerta después de 3 segundos
    setTimeout(function () {
      alertContainer.addClass("d-none");
      alertContainer.removeClass("alert-danger"); // Elimina la clase alert-danger para futuras alertas
    }, 3000); // Asegúrate de que este tiempo es el que quieres (3 segundos en este caso)
  }
});