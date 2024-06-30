import { obtener_listas, obtener_datos_usuario, crear_lista } from "./ajax.js";

$(document).ready(function () {
  // Manejo del botón para ocultar el menú lateral
  $("#toggleSidebar").on("click", function () {
    $("#sidebar").toggleClass("collapsed");
    $("#content").toggleClass("collapsed");
    $("#navbar").toggleClass("collapsed");
    $("#footer").toggleClass("collapsed");

    // Ajuste de los enlaces y detalles del usuario según el estado del menú
    if ($("#sidebar").hasClass("collapsed")) {
      $(".nav-link").addClass("collapsed");
      $(".nav-link-2").addClass("collapsed");
      $(".listadoListas").addClass("collapsed");
      $(".addList").addClass("collapsed");
      $(".user-info").addClass("collapsed");
      $(".userDropdownMenu").addClass("collapsed");
      $(".toggle-container img").hide();
      $(".toggle-container h6").hide();
    } else {
      $(".nav-link").removeClass("collapsed");
      $(".nav-link-2").removeClass("collapsed");
      $(".listadoListas").removeClass("collapsed");
      $(".addList").removeClass("collapsed");
      $(".user-info").removeClass("collapsed");
      $(".userDropdownMenu").removeClass("collapsed");
      $(".toggle-container img").show();
      $(".toggle-container h6").show();
    }
  });

  // Manejo del clic en el icono de añadir
  $(".addList").on("click", function () {
    // Crear el modal dinámicamente
    var modalHtml = `
    <div class="modal fade" id="crearListaModal" tabindex="-1" role="dialog" aria-labelledby="crearListaModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="crearListaModalLabel">Crear Nueva Lista</h5>
          </div>
          <div class="modal-body">
            <input type="text" id="nombreLista" class="form-control" placeholder="Nombre de la lista">
            <p id="errorNombreLista" class="text-danger d-none">El nombre de la lista no puede estar vacío.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn close" data-dismiss="modal" id="cancelarBtn">Cancelar</button>
            <button type="button" id="crearListaBtn" class="btn aceptar">Crear Lista</button>
          </div>
        </div>
      </div>
    </div>
    `;
    // Agregar el modal al final del cuerpo del documento
    $("body").append(modalHtml);

    // Mostrar el modal
    $("#crearListaModal").modal("show");

    // Enfocar el campo de entrada del nombre de la lista
    $("#nombreLista").focus();
  });

  // Manejo del clic en el botón 'Cancelar' dentro del modal
  $(document).on("click", "#cancelarBtn", function () {
    // Ocultar el modal
    $("#crearListaModal").modal("hide");
  });

  // Manejo del clic en el botón 'Crear Lista' dentro del modal
  $(document).on("click", "#crearListaBtn", function () {
    crearLista();
  });

  // Manejo de la pulsación de la tecla Enter en el campo de entrada del nombre de la lista
  $(document).on("keypress", "#nombreLista", function (e) {
    if (e.which === 13) {
      crearLista();
    }
  });

  // Función para crear la lista
  function crearLista() {
    var nombreLista = $("#nombreLista").val(); // Obtener el nombre de la lista del input

    // Verificar que se haya ingresado un nombre para la lista
    if (nombreLista.trim() === "") {
      $("#errorNombreLista").removeClass("d-none");
      return;
    }

    // Llamar a la función para crear la lista
    crear_lista(nombreLista)
      .then(function (data) {
        // Si la lista se crea con éxito, cerrar el modal y recargar las listas
        $("#crearListaModal").modal("hide");
        obtener_listas().then(function (listas) {
          mostrar_listas(listas);
        });
      })
      .catch(function (error) {
        // Si hay un error al crear la lista, mostrar un mensaje de error
        mostrarError("Error al crear la lista: " + error);
      });
  }

  // Función para mostrar u ocultar el menú desplegable del usuario al hacer clic en los tres puntos
  $("#userDropdownIcon").on("click", function () {
    const userDropdownMenu = $(".userDropdownMenu");
    userDropdownMenu.toggle();
  });

  // Ocultar el menú desplegable del usuario al hacer clic fuera de él
  $(document).on("click", function (event) {
    if (!$(event.target).closest(".dropdown").length) {
      $(".userDropdownMenu").hide();
    }
  });

  // Obtenemos las listas del usuario
  obtener_listas()
    .then((listas) => {
      // Luego, mostramos las listas del usuario
      mostrar_listas(listas);
    })
    .catch((error) => {
      console.error("Error al obtener las listas del usuario:", error);
    });

  // Obtenemos las datos del usuario
  obtener_datos_usuario()
    .then((usuario) => {
      // Verificar si el usuario tiene una foto, si no, usar la imagen por defecto
      var foto = usuario.foto ? usuario.foto : "uploads/defecto.jpg";

      // Actualizar la información del usuario en la vista
      $(".user-info img").attr("src", foto);
      $(".user-info .user-details strong").text(usuario.nombre);
    })
    .catch((error) => {
      console.error("Error al obtener los datos del usuario:", error);
    });

  /* Función para mostrar las listas del usuario */
  function mostrar_listas(listas) {
    // Seleccionamos el elemento donde se cargarán las listas del usuario
    var listadoListas = $(".listadoListas");

    // Limpiamos el contenido actual
    listadoListas.empty();

    // Verificamos si hay listas
    if (listas.length > 0) {
      // Recorremos las listas y creamos las opciones
      listas.forEach(function (lista) {
        // Creamos un elemento de opción
        var listaItem = $("<a>", {
            href: "index.php?controller=lista_controlador&action=obtener_contenido&id_lista=" + lista.id,
            class: "lista-item" // Añadimos la clase 'lista-item' a cada elemento de opción
        });

        // Creamos el elemento del icono
        var icono = $("<i>", {
            class: "fa-solid fa-chevron-right me-2"
        });

        // Agregamos el icono al enlace
        listaItem.append(icono).append(lista.nombre);

        // Agregamos la opción al contenedor
        listadoListas.append(listaItem);
    });
    } else {
      // Si no hay listas, mostramos un mensaje indicando que no hay ninguna lista creada
      var message = $("<div>", {
        class: "lista-item",
      }).text("No hay ninguna lista creada");

      // Agregamos el mensaje al contenedor
      listadoListas.append(message);
    }
  }

  // Manejo de la busqueda en el navbar
  $("#navbarInput").on("keypress", function (e) {
    if (e.which === 13) {
      // Enter key pressed
      obtener_busqueda();
    }
  });

  $("#navbarSearchIcon").on("click", function () {
    obtener_busqueda();
  });

  function obtener_busqueda() {
    var query = $("#navbarInput").val().trim();
    if (query !== "") {
      window.location.href =
        "index.php?controller=buscar_controlador&action=mostrar_vista&query=" +
        encodeURIComponent(query);
    }
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
