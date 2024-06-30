<div id="alert-container" class="alert alert-lg d-none position-absolute top-50 start-50 translate-middle shadow-lg" role="alert"></div>
<div class="mis-libros-titulo">
    <h1>Mis Libros</h1>
</div>
<div class="input-group mb-3 buscar-libros">
    <input id="buscar_en_libros" type="search" class="form-control form-control-lg buscaInput" placeholder="Introduce el nombre de un libro">
    <div class="input-group-append">
        <button type="submit" class="btn iconoLupa">
            <i class="fa fa-search fa-lg"></i>
        </button>
    </div>
</div>
<div id="mis_libros">
    <!-- Aquí se cargarán los libros del usuario -->
</div>
<!-- Modal para escribir comentario -->
<div class="modal fade" id="modal-comentario" tabindex="-1" role="dialog" aria-labelledby="modal-comentario-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-comentario-label">Escribir reseña</h5>
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
<!-- Modal para ver el comentario -->
<div class="modal fade" id="modal-ver-comentario" tabindex="-1" role="dialog" aria-labelledby="modal-ver-comentario-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-ver-comentario-label">Reseña del libro</h5>
            </div>
            <div class="modal-body">
                <p id="contenido-comentario"></p>
            </div>
            <div class="modal-footer">
                <button id="eliminar-comentario-btn" class="btn aceptar" data-dismiss="modal">Eliminar</button>
                <button type="button" class="btn close" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmación para eliminar el libro -->
<div class="modal fade" id="modal-confirmacion-eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Libro</h5>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este libro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn aceptar" id="confirmar-eliminar-btn">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmación de cambio de valoración -->
<div class="modal fade" id="modal-confirmacion-valoracion" tabindex="-1" aria-labelledby="modal-confirmacion-valoracion-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-confirmacion-valoracion-label">Cambiar valoración</h5>
            </div>
            <div class="modal-body">
                <p>¿Desea cambiar su valoración?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn aceptar" id="confirmar-cambio-valoracion-btn">Confirmar</button>
            </div>
        </div>
    </div>
</div>