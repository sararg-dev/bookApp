import { obtener_datos_usuario } from "./ajax.js";

$(document).ready(function () {
  // Obtener datos del usuario y rellenar el formulario
  obtener_datos_usuario()
    .then((data) => {
      var foto = data.foto ? data.foto : "uploads/defecto.jpg";
      $("#foto").attr("src", foto);
      $("#nombre").val(data.nombre);
      $("#email").text(data.email);
      // Formatear la fecha para mostrar solo la parte de la fecha sin la hora
      var fecha = data.fecha.split(" ")[0]; // Asumiendo que el formato es 'YYYY-MM-DD HH:MM:SS'
      $("#fechaRegistro").text(fecha);
    })
    .catch((error) => {
      alert(error);
    });

  // Manejar la visibilidad del input password
  $(".eye-icon").click(function () {
    const input = $(this).prev("input");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
      $(this).removeClass("fa-eye-slash").addClass("fa-eye");
    } else {
      input.attr("type", "password");
      $(this).removeClass("fa-eye").addClass("fa-eye-slash");
    }
  });

  // Manejar el cambio de foto de perfil
  $("#cambiar_foto").on("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#foto").attr("src", e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // Limpiar mensaje de error al escribir en los campos
  $("#nombre, #claveActual, #nuevaClave, #confirmarClave").on(
    "input",
    function () {
      $(".error").text("");
      $(".exito").text("");
    }
  );

  // Manejar la actualización del perfil
  $("#editarPerfilForm").on("submit", function (e) {
    e.preventDefault();

    var nombre = $("#nombre").val().trim();
    var clave = $("#claveActual").val().trim();
    var nuevaClave = $("#nuevaClave").val().trim();
    var confirmarClave = $("#confirmarClave").val().trim();

    // Verificar si los campos están vacíos o no son correctos
    if (nombre === "") {
      $(".error").text("El nombre de usuario no puede quedar vacío.");
      return; // Detener la ejecución del formulario
    }

    if (clave === "") {
      $(".error").text("Ingrese su contraseña actual para realizar cambios.");
      return; // Detener la ejecución del formulario
    }

    if (nuevaClave !== confirmarClave) {
      $(".error").text("Debes confirmar la nueva contraseña.");
      return; // Detener la ejecución del formulario
    }

    // Limpiar mensaje de error  y exito antes de enviar
    $(".error").text("");
    $(".exito").text("");

    // Si todas las validaciones pasan, enviar el formulario
    this.submit();
  });
  $(document).on("click", ".close", function () {
    $(" #modal-confirmacion-eliminar").modal("hide");
  });
  // Manejar la eliminación de la cuenta
  // Mostrar el modal de confirmación al hacer clic en el botón de eliminar cuenta
  $("#eliminarCuentaBtn").on("click", function () {
    $("#modal-confirmacion-eliminar").modal("show");
  });

  // Manejar la confirmación de eliminación
  $("#confirmar-eliminar-btn").on("click", function () {
    window.location.href =
      "index.php?controller=acceso_controlador&action=eliminar";
  });
});
