$(document).ready(function () {
  // Función para validar el formato del email
  function validarEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }

  // Mostrar/ocultar contraseña
  $("#togglePassword").click(function () {
    var passwordInput = $("#password");
    var type = passwordInput.attr("type") === "password" ? "text" : "password";
    passwordInput.attr("type", type);
    $(this).toggleClass("fa-eye-slash fa-eye");
  });

  // Limpiar mensaje de error al escribir en los campos
  $("#email, #password").on("input", function () {
    $(".error").text("");
  });

  // Validar el formulario antes de enviar
  $("#iniciarSesionForm").submit(function (event) {
    event.preventDefault();

    var email = $("#email").val().trim();
    var password = $("#password").val();

    // Verificar si los campos están vacíos
    if (email === "" || password === "") {
      $(".error").text("Por favor, rellene todos los campos");
      return; // Detener la ejecución del formulario
    }

    // Verificar el formato del email
    if (!validarEmail(email)) {
      $(".error").text("El formato del email es incorrecto");
      return; // Detener la ejecución del formulario
    }

    // Limpiar mensaje de error antes de enviar
    $(".error").text("");

    // Si todas las validaciones pasan, enviar el formulario
    this.submit();
  });
});
