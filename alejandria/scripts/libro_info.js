import {
  obtener_libro_info,
  obtener_comentarios_libro,
  obtener_libros_usuario,
} from "./ajax.js";

$(document).ready(function () {
  var urlParams = new URLSearchParams(window.location.search);
  var idApi = urlParams.get("idApi");

  obtener_libro_info(idApi)
    .then(function (response) {
      mostrar_contenido(response);
      return response;
    })
    .catch(function (error) {
      console.error("Error al obtener la información del libro:", error);
    });

  obtener_comentarios_libro(idApi)
    .then(function (comentarios) {
      mostrar_comentarios(comentarios);
    })
    .catch(function (error) {
      console.error("Error al obtener los comentarios del libro:", error);
    }); 

  function mostrar_contenido(libro) {
    var contenidoHTML = `
      <div class="row">
        <div class="col-md-2 col-4 book-cover-container">
          <img src="${
            libro.volumeInfo.imageLinks.thumbnail
          }" alt="Portada del libro" class="img-fluid">
        </div>
        <div class="col-md-8 col-8">
          <h1 class="titulo">${libro.volumeInfo.title}</h1>
          <h4 class="autor">${libro.volumeInfo.authors.join(", ")}</h4><hr>
          <p><strong>Fecha de publicación:</strong> ${
            libro.volumeInfo.publishedDate
          }</p>
          <p><strong>Descripción:</strong> <span class="description">${
            libro.volumeInfo.description
          }</span></p>
        </div>
      </div>
    `;

    $("#libro_info").html(contenidoHTML);
  }
  

  obtener_libros_usuario()
  .then(function (libros) {
    var libroGuardado = libros.find((libro) => libro.idApi === idApi);
    if (libroGuardado) {
      var id_libro = libroGuardado.id;
      console.log("Id del libro: " + id_libro);
      $("#escribir-comentario-btn").prop("disabled", false);
      $("#mensaje-aviso").hide();
    } else {
      var id_libro = null;
      $("#escribir-comentario-btn").prop("disabled", true);
      $("#mensaje-aviso").show();
    }
    $("#escribir-comentario-btn").data("id-libro", id_libro);
  })
  .catch(function (error) {
    console.error("Error al obtener los libros del usuario:", error);
  });

  function mostrar_comentarios(comentarios) {
    var comentariosHtml = `
      <div class="comentarios-header row">
        <div class="col-12 col-md-6">
          <h4>Reseñas de los usuarios</h4>
        </div>
      </div>
      <div class="mt-4">
    `;
    if (comentarios && comentarios.length > 0) {
      $.each(comentarios, function (index, comentario) {
        var contenido = comentario.contenido;
        var usuario_foto = comentario.usuario_foto
          ? comentario.usuario_foto
          : "uploads/defecto.jpg";
        var usuario_nombre = comentario.usuario_nombre;
        var fecha = comentario.fecha;

        comentariosHtml += `
          <div class="comentario row mb-4">
            <div class="col-2 text-center">
              <img src="${usuario_foto}" alt="Foto de usuario" class="foto-usuario">
              <h5 class="nombre-usuario">${usuario_nombre}</h5>
            </div>
            <div class="col-10">
              <p class="fecha-comentario text-muted">${fecha}</p>
              <p class="contenido-comentario">${contenido}</p>
            </div>
          </div>
          <hr>
        `;
      });
    } else {
      comentariosHtml += `<p class="text-center">Todavía hay reseñas para este libro.</p>`;
    }
    comentariosHtml += "</div>";
    $("#comentarios").html(comentariosHtml);
  } 

 $(document).on("click", "#escribir-comentario-btn", function () {
    var id_libro = $(this).data("id-libro");
    $("#modal-comentario").data("id-libro", id_libro).modal("show");
  });

  $(document).on("click", ".close", function () {
    $("#modal-comentario").modal("hide");
  });

  $(document).on("click", "#guardar-comentario-btn", function () {
    var contenido = $("#comentario-texto").val().trim();
    var id_libro = $("#escribir-comentario-btn").data("id-libro");
    console.log("id_libro " + id_libro);
    if (contenido === "") {
      mostrarError("¡La reseña no puede quedar vacía!");
    } else {
      guardar_comentario(id_libro, contenido)
        .then(function (response) {
          mostrarExito("Reseña guardada correctamente!.");
          setTimeout(function () {
            location.reload();
          }, 3000);
          $("#modal-comentario").modal("hide");
        })
        .catch(function (error) {
          console.error("Error al guardar el comentario:", error);
        });
    }
  }); 

  function mostrarExito(mensaje) {
    var alertContainer = $("#alert-container");
    alertContainer.text(mensaje);
    alertContainer.removeClass("d-none alert-danger alert-warning alert-info");
    alertContainer.addClass("alert-success");
    alertContainer.show();

    setTimeout(function () {
      alertContainer.addClass("d-none");
      alertContainer.removeClass("alert-success");
    }, 3000);
  }

  function mostrarError(mensaje) {
    var alertContainer = $("#alert-container");
    alertContainer.text(mensaje);
    alertContainer.removeClass("d-none alert-success alert-warning alert-info");
    alertContainer.addClass("alert-danger");
    alertContainer.show();

    setTimeout(function () {
      alertContainer.addClass("d-none");
      alertContainer.removeClass("alert-danger");
    }, 3000);
  }
});
