<?php
$error = $exito = "";

if (isset($data["data"]["error_message"])) {
    $error = $data["data"]["error_message"];
}

if (isset($data["data"]["mensaje_exitoso"])) {
    $exito = $data["data"]["mensaje_exitoso"];
}
?>
<div class="settings_container container">
    <h2 class="text-center mb-5">Editar Perfil</h2>
    <form id="editarPerfilForm" action="index.php?controller=acceso_controlador&action=actualizar" method="post" enctype="multipart/form-data" class="mt-5">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="form-group">
                    <label for="cambiar_foto" class="profile-label">
                        <img src="" alt="Foto de perfil" class="profile-img" id="foto">
                        <div class="edit-overlay">
                            <i class="fa-solid fa-pen-to-square fa-xl mb-3"></i>
                            <strong>Cambiar foto</strong>
                        </div>
                    </label>
                    <input type="file" class="form-control-file" id="cambiar_foto" name="cambiar_foto" style="display: none;">
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <p id="email"></p>
                </div>
                <div class="form-group">
                    <label for="fechaRegistro">Fecha de Registro</label>
                    <p id="fechaRegistro"></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre de Usuario</label>
                    <input type="text" class="form-control mt-2" id="nombre" name="nombre">
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="claveActual">Contraseña Actual</label>
                    <input type="password" class="form-control mt-1" id="claveActual" name="claveActual">
                    <i class="far fa-eye-slash eye-icon" id="toggleClaveActual"></i>
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="nuevaClave">Nueva Contraseña</label>
                    <input type="password" class="form-control mt-1" id="nuevaClave" name="nuevaClave">
                    <i class="far fa-eye-slash eye-icon" id="toggleNuevaClave"></i>
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="confirmarClave">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control mt-1" id="confirmarClave" name="confirmarClave">
                    <i class="far fa-eye-slash eye-icon" id="toggleConfirmarClave"></i>
                </div>
            </div>
        </div>
        <div class="row botones_edit">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-aceptar">Aceptar</button>
                <button type="reset" class="btn btn-cancelar">Cancelar</button>
            </div>
            <div class="col-md-12 text-center mt-3">
                <button type="button" class="btn btn-danger" id="eliminarCuentaBtn">Eliminar Cuenta</button>
            </div>
        </div>
        <!-- Mostrar mensaje de error o éxito-->
        <p class="text-center mt-2 mb-5 error" style="color:red"><?php echo $error; ?></p>
        <p class="text-center mt-2 mb-5 exito" style="color:green"><?php echo $exito; ?></p>
    </form>
    <!-- Modal de confirmación para eliminar la cuenta -->
    <div class="modal fade" id="modal-confirmacion-eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar cuenta</h5>
                </div>
                <div class="modal-body">
                ¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn close" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn aceptar" id="confirmar-eliminar-btn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>