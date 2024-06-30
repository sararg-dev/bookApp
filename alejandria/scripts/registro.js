$(document).ready(function () {
    // Función para validar el formato del email
    function validarEmail(email) {
      var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }
  
    // Función para validar el formato de la contraseña
    function validarPassword(password) {
      var re = /^(?=.*\d).{8,}$/; // Al menos 8 caracteres y un número
      return re.test(password);
    }
  
    // Mostrar/ocultar contraseña
    $("#togglePassword, #togglePassword2").click(function () {
      var passwordInput = $("#password");
      var confirmPasswordInput = $("#confirm-password");
      var type = passwordInput.attr("type") === "password" ? "text" : "password";
      passwordInput.attr("type", type);
      confirmPasswordInput.attr("type", type);
      $(this).toggleClass("fa-eye-slash fa-eye");
    });
  
    // Limpiar mensaje de error al escribir en los campos
    $("#username, #email, #password, #confirm-password, #terms").on(
      "input change",
      function () {
        $(".error").text("");
      }
    );
  
    // Validar el formulario antes de enviar
    $("#registroForm").submit(function (event) {
      event.preventDefault();
  
      var email = $("#email").val().trim();
      var password = $("#password").val();
      var confirmPassword = $("#confirm-password").val();
      var termsChecked = $("#terms").is(":checked");
  
      // Verificar si los campos están vacíos
      if ($("#username").val().trim() === "" || email === "" || password === "" || confirmPassword === "") {
        $(".error").text("Por favor, rellene todos los campos");
        return; // Detener la ejecución del formulario
      }
  
      // Verificar el formato del email
      if (!validarEmail(email)) {
        $(".error").text("El formato del email es incorrecto");
        return; // Detener la ejecución del formulario
      }
  
      // Verificar el formato de la contraseña
      if (!validarPassword(password)) {
        $(".error").text("La contraseña debe tener al menos 8 caracteres y contener al menos un número");
        return; // Detener la ejecución del formulario
      }
  
      // Verificar si las contraseñas coinciden
      if (password !== confirmPassword) {
        $(".error").text("Las contraseñas no coinciden");
        return; // Detener la ejecución del formulario
      }
  
      // Verificar si los términos y condiciones están marcados
      if (!termsChecked) {
        $(".error").text("Debe aceptar los términos y condiciones");
        return; // Detener la ejecución del formulario
      }
  
      // Limpiar mensaje de error antes de enviar
      $(".error").text("");
  
      // Si todas las validaciones pasan, enviar el formulario
      this.submit();
    });
  });
  