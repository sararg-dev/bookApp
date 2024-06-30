<div id="alert-container" class="alert alert-lg d-none position-absolute top-50 start-50 translate-middle shadow-lg" role="alert"></div>
<div id="libro_info" class="container">
    <!-- Aquí se cargará la información del libro -->
</div>
<div id="comentarios" class="comentarios-container container">
    <!-- Aquí se cargarán los comentarios de los usuarios -->
</div>
<!-- Modal para escribir comentario -->
<div class="modal fade" id="modal-comentario" tabindex="-1" role="dialog" aria-labelledby="modal-comentario-label" aria-hidden="true">
    <div id="alert-container" class="alert alert-danger alert-lg d-none position-absolute top-50 start-50 translate-middle shadow-lg" role="alert"></div>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-comentario-label">Escribir un comentario</h5>
            </div>
            <div class="modal-body">
                <textarea id="comentario-texto" class="form-control" rows="4"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close" data-dismiss="modal">Cerrar</button>
                <button id="guardar-comentario-btn" class="btn aceptar">Aceptar</button>
            </div>
        </div>
    </div>
</div>