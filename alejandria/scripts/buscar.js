import { guardar_libro } from "./ajax.js";

$(document).ready(function () {
  // Variables de búsqueda
  var inputBuscar = $("#input_buscar");
  var btnBuscar = $("#btn_buscar");
  var btnSearchAll = $("#search-all");
  var btnSearchGenre = $("#search-genre");
  var btnSearchAuthor = $("#search-author");
  var searchType = "todo";
  var maxResults = 20; // Número máximo de resultados por búsqueda

  // Comprobar si hay un parámetro de búsqueda en la URL
  var urlParams = new URLSearchParams(window.location.search);
  var query = urlParams.get("query");

  if (query) {
    inputBuscar.val(query);
    buscarLibros();
  } else {
    inputBuscar.val("");
  }

  // Event listeners para botones de búsqueda
  btnSearchAll.click(function () {
    searchType = "todo";
    buscarLibros();
  });

  btnSearchGenre.click(function () {
    searchType = "genero";
    buscarLibros();
  });

  btnSearchAuthor.click(function () {
    searchType = "autor";
    buscarLibros();
  });

  btnBuscar.click(function (event) {
    event.preventDefault();
    buscarLibros();
  });

  inputBuscar.on('input', function() {
    buscarLibros();
  });

  function buscarLibros() {
    var query = inputBuscar.val().trim();

    if (query !== "") {
      var url = "https://www.googleapis.com/books/v1/volumes?q=";
      if (searchType === "todo") {
        url += encodeURIComponent(query);
      } else if (searchType === "genero") {
        url += "subject:" + encodeURIComponent(query);
      } else if (searchType === "autor") {
        url += "inauthor:" + encodeURIComponent(query);
      }
      url += `&maxResults=${maxResults}&key=AIzaSyDpgUD-BMi-S5nxL6AqWmA6soOs2-Qj2V8`;

      $.ajax({
        url: url,
        method: "GET",
        success: function (response) {
          mostrarResultados(response.items);
        },
        error: function () {
          $("#resultados").html(
            "Error al buscar libros. Por favor, inténtalo de nuevo más tarde."
          );
        },
      });
    } else {
      $("#resultados").html("Por favor, introduce un término de búsqueda.");
    }
  }

  function mostrarResultados(books) {
    var html = "";

    if (books.length > 0) {
      books.forEach(function (book) {
        var title = book.volumeInfo.title;
        var authors = book.volumeInfo.authors
          ? book.volumeInfo.authors.join(", ")
          : "Autor desconocido";
        var thumbnail = book.volumeInfo.imageLinks
          ? book.volumeInfo.imageLinks.thumbnail
          : "https://via.placeholder.com/128x196?text=No+disponible";

        html += `
                  <div class="resultado">
                      <div class="libro_portada">
                          <a href="index.php?controller=libro_controlador&action=obtener_libro&idApi=${book.id}" class="nav-link">
                              <img src="${thumbnail}" alt="Portada del libro">
                          </a>
                      </div>
                      <div class="libro_detalle">
                          <h5>
                              <a href="index.php?controller=libro_controlador&action=obtener_libro&idApi=${book.id}" class="nav-link">
                                  ${title}
                              </a>
                          </h5>
                          <p>${authors}</p>
                          <div class="libro_acciones">
                              <div class="select-listas-container-${book.id}"></div>
                              <a href="index.php?controller=libro_controlador&action=obtener_libro&idApi=${book.id}" class="btn btn-general">Más información</a>
                          </div>
                      </div>
                  </div>
              `;

        crearSelectListas(book, book.id);
      });
    } else {
      html = "<p>No se encontraron resultados para tu búsqueda.</p>";
    }

    $("#resultados").html(html);
  }

  function crearSelectListas(book, bookId) {
    $.ajax({
      url: "index.php?controller=lista_controlador&action=obtener_listas",
      method: "GET",
      success: function (response) {
        if (response && response.length > 0) {
          var select = '<select class="form-select">';
          select += "<option selected>Añadir a lista</option>";
          response.forEach(function (lista) {
            select +=
              '<option value="' + lista.id + '">' + lista.nombre + "</option>";
          });
          select += "</select>";

          $(`.select-listas-container-${bookId}`).html(select);

          $(`.select-listas-container-${bookId} select`).change(function () {
            var listaId = $(this).val();
            if (listaId !== "Añadir a lista") {
              console.log("Llamando a guardar_libro con libro: ", book, " y listaId: ", listaId);
              guardar_libro(book, listaId)
                .then(function (response) {
                  console.log("Respuesta: " + response); // Añade esto para ver la respuesta en la consola
                  if (response) {
                    $(`.select-listas-container-${bookId} select`).css("background-color", "#BD871F");
                    mostrarExito("Libro agregado con éxito.");
                  } else {
                    console.error("Error al guardar el libro:", error);
                  }
                })
                .catch(function (error) {
                  console.error("Error al guardar el libro:", error);
                });
            }
          });
        } else {
          $(`.select-listas-container-${bookId}`).html(
            "<p>No hay listas disponibles</p>"
          );
        }
      },
      error: function () {
        $(`.select-listas-container-${bookId}`).html(
          "<p>Error al cargar las listas</p>"
        );
      },
    });
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
