<?php
$error = "";

if (isset($data["data"]["error_message"])) {
    $error = $data["data"]["error_message"];
}
?>
<div class="contenedor_acceso">
    <div class="logo-registro mb-5">
        <img src="comun/img/logo.png" alt="Logotipo de la web">
        <h1>ALEJANDRÍA</h1>
    </div>
    <div id="registro_container">
        <h3 class="text-center mb-5">Registro</h3>
        <form action="index.php?controller=acceso_controlador&action=registrar" method="post" id="registroForm" class="row">
            <div class="col-md-6 mb-4">
                <div class="form-group mb-3">
                    <label for="username">Nombre de Usuario</label>
                    <input type="text" class="form-control mt-2" id="username" name="nombre_usuario" placeholder="Introduce tu nombre de usuario">
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control mt-2" id="email" name="email" placeholder="ejemplo@dominio.com">
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="form-group password-container mb-3">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control mt-2" id="password" name="clave" placeholder="Introduce tu contraseña">
                    <i class="far fa-eye-slash eye-icon" id="togglePassword"></i>
                </div>
                <div class="form-group password-container">
                    <label for="confirm-password">Repetir Contraseña</label>
                    <input type="password" class="form-control mt-2" id="confirm-password" name="clave2" placeholder="Repite tu contraseña">
                    <i class="far fa-eye-slash eye-icon" id="togglePassword2"></i>
                </div>
            </div>
            <div class="form-group form-check mb-3 ms-3">
                <input type="checkbox" class="form-check-input mt-2" id="terms">
                <label class="form-check-label" for="terms">Acepto los <a href="index.php?controller=acceso_controlador&action=mostrar_terminos" target="_blank">términos y condiciones</a></label>
            </div>
            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-general">Registrarse</button>
            </div>
            <p class="text-center mt-2 error" style="color:red"><?php echo $error; ?></p>
            <div class="text-center mt-3">
                <small>¿Ya tienes una cuenta? <a href="index.php?">Inicia sesión</a></small>
            </div>
        </form>
    </div>
</div>