<div id="alert-container" class="alert alert-lg d-none position-absolute top-50 start-50 translate-middle shadow-lg" role="alert"></div>
<div id="lista_titulo_container">
    <h1 id="lista_titulo"></h1>
    <i class="fa-solid fa-pen-to-square fa-xl btn_editar" id="editar_lista"></i>
    <i class="fa-solid fa-xmark fa-xl btn_eliminar" id="eliminar_lista"></i>
</div>
<div id="lista_contenido">
    <!-- Aquí se cargará el contenido de la lista -->
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
                ¿Desea cambiar su valoración?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn aceptar" id="confirmar-cambio-valoracion-btn">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para editar el nombre de la lista -->
<div class="modal fade" id="modal-editar-lista" tabindex="-1" role="dialog" aria-labelledby="editarListaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarListaLabel">Editar nombre de la lista</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="nuevo_nombre_lista" class="form-control" placeholder="Nuevo nombre de la lista">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn aceptar" id="guardar_nombre_lista">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar la eliminación de la lista -->
<div class="modal fade" id="modal-confirmar-eliminar-lista" tabindex="-1" role="dialog" aria-labelledby="confirmarEliminarListaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarEliminarListaLabel">Eliminar lista</h5>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta lista?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn aceptar" id="confirmar_eliminar_lista">Eliminar</button>
            </div>
        </div>
    </div>
</div>