<?php
$error = "";

if (isset($data["data"]["error_message"])) {
    $error = $data["data"]["error_message"];
}

$exito = isset($_GET['mensaje_exitoso']) && $_GET['mensaje_exitoso'] == 1;
?>
<div class="contenedor_acceso pt-5">
  <div class="logotipo">
    <img src="comun/img/logo.png" alt="Logotipo de la web">
    <h1>ALEJANDRÍA</h1>
  </div>
  <div id="login_container">
    <h3 class="text-center mb-4">Iniciar Sesión</h3>
    <?php if ($exito): ?>
            <p class="text-success">¡Cuenta creada correctamente! Por favor, inicia sesión.</p>
    <?php endif; ?>
    <form id="iniciarSesionForm" action="index.php?controller=acceso_controlador&action=iniciar_sesion" method="post">
      <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control mt-2" id="email" name="email" placeholder="ejemplo@dominio.com">
      </div>
      <div class="form-group mb-3 password-container">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control mt-2" id="password" name="clave">
        <i class="far fa-eye-slash eye-icon" id="togglePassword"></i>
      </div>
      <div class="form-group text-center mt-4">
        <button type="submit" class="btn btn-general">Iniciar Sesión</button>
      </div>
      <!-- Mostrar mensaje de error -->
      <p class="text-center mt-2 error" style="color:red"><?php echo $error; ?></p>
      <!-- Fin de mostrar mensaje de error -->
      <div class="text-center mt-3">
        <small>¿No tienes una cuenta? <a href="index.php?controller=acceso_controlador&action=registrar">Registro</a></small>
      </div>
    </form>
  </div>
</div>
