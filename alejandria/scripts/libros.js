import {
  obtener_libros_usuario,
  buscar_libro,
  obtener_lista,
  obtener_comentarios,
  eliminar_libro,
  obtener_valoracion,
  guardar_valoracion,
  actualizar_valoracion,
  guardar_comentario,
  eliminar_comentario,
} from "./ajax.js";
$(document).ready(function () {
  // Cargamos los libros del usuario al mostrar la vista
  obtener_libros_usuario()
    .then(function (libros) {
      console.log(libros);
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
      console.error("Error al obtener los libros del usuario:", error);
      $("#mis_libros").html(
        "Error al buscar libros. Por favor, inténtalo de nuevo más tarde."
      );
    });

  // Agrega un evento de escucha al campo de búsqueda que se activa cuando se ingresa una letra
  $(document).on("input", "#buscar_en_libros", function () {
    // Obtiene el valor actual del campo de búsqueda
    var titulo = $(this).val();
    console.log("Input: " + titulo);
    // Llama a la función buscar_libro con el título como argumento
    buscar_libro(titulo)
      .then(function (librosEncontrados) {
        console.log("Libros encontrados:", librosEncontrados);
        // Obtener detalles adicionales para cada libro encontrado
        var detallePromesas = librosEncontrados.map((libro) =>
          obtenerDetallesLibro(libro)
        );
        return Promise.allSettled(detallePromesas);
      })
      .then(function (results) {
        const librosConDetalles = results
          .filter((result) => result.status === "fulfilled")
          .map((result) => result.value)
          .filter((libro) => libro !== null); // Filtramos los null que puedan haber
        // Borra el contenido anterior del contenedor de libros
        $("#mis_libros").empty();
        // Muestra los libros encontrados con los detalles obtenidos
        mostrar_contenido(librosConDetalles);
      })
      .catch(function (error) {
        console.error("Error al buscar libros:", error);
        $("#mis_libros").html("No se encontraron resultados.");
      });
  });

  function obtenerDetallesLibro(libro) {
    const id_libro = libro.id;
    return Promise.all([
      obtener_lista(id_libro),
      obtener_comentarios(id_libro),
      obtener_valoracion(id_libro),
    ])
      .then(function ([resultado_lista, comentarios, valoracion]) {
        const nombre_lista = resultado_lista.nombre_lista; // Accede al nombre de la lista
        libro.lista = nombre_lista ? nombre_lista : "Sin lista";
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
    var contenedor = $("#mis_libros");

    // Limpiamos el contenido anterior del contenedor
    contenedor.empty();
    // Verifica si hay libros
    if (libros.length === 0) {
      console.log(libros);
      var libroHTML = `<div>No hay libros para mostrar.</div>`;
    } else {
      // Añadimos el encabezado
      var libroHTML = `
       <div class="book-row-header">
          <div class="book-details"><strong>Título</strong></div>
          <div class="book-author"><strong>Autor</strong></div>
          <div class="book-list"><strong>Lista</strong></div>
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
          <div class="book-row" data-libro-id="${libro.id}">
            <div class="book-details">
              <a href="index.php?controller=libro_controlador&action=obtener_libro&idApi=${
                libro.idApi
              }" class="nav-link">
                <img src="${
                  libro.portada
                }" alt="Portada del libro" class="book-cover">
              </a>
              <div class="book-info">
                <a href="index.php?controller=libro_controlador&action=obtener_libro&idApi=${
                  libro.idApi
                }" class="nav-link">
                  <h5>${libro.titulo}</h5>
                </a>
              </div>
            </div>
            <div class="book-author">
                <p>${libro.autor}</p>
            </div>
            <div class="book-list">
                <p>${libro.lista}</p>
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
            <div class="book-review" title="Valorar">
                <button class="btn btn-general${
                  libro.comentarios ? "-ver-comentario" : " escribir-comentario"
                }" data-id="${libro.id}" 
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
                  libro.id
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
      mostrar_valoracion(libro.id, libro.valoracion);
    });

    // Evento clic para abrir el modal de comentario
    $(document).on("click", ".escribir-comentario", function () {
      var id_libro = $(this).data("id"); // Obtener el ID del libro desde el botón
      $("#modal-comentario").data("id-libro", id_libro).modal("show");
    });

    // Evento clic para cerrar el modal
    $(document).on("click", ".close", function () {
      $(
        "#modal-comentario, #modal-ver-comentario, #modal-confirmacion-eliminar, #modal-confirmacion-valoracion"
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
              obtener_libros_usuario()
                .then(function (libros) {
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
                  console.error(
                    "Error al obtener los libros del usuario:",
                    error
                  );
                  $("#mis_libros").html(
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
            obtener_libros_usuario()
              .then(function (libros) {
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
                console.error(
                  "Error al obtener los libros del usuario:",
                  error
                );
                $("#mis_libros").html(
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
            obtener_libros_usuario()
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
                console.error(
                  "Error al obtener los libros del usuario:",
                  error
                );
                $("#mis_libros").html(
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
