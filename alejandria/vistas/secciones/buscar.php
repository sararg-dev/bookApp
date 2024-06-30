<div class="busqueda container mt-5 mb-5">
    <h2 class="text-center display-4">Buscar</h2>
    <div class="col-md-6 offset-md-3"> <!-- Modificado -->
        <div id="alert-container" class="alert alert-lg d-none position-absolute top-50 start-50 translate-middle shadow-lg" role="alert"></div>
    </div>
    <form class="mb-5">
        <div class="input-group mb-3 justify-content-center">
            <input id="input_buscar" type="search" class="form-control form-control-lg buscaInput" placeholder="¿Qué libro deseas buscar?">
            <div class="input-group-append">
                <button id="btn_buscar" type="submit" class="btn iconoLupa">
                    <i class="fa fa-search fa-lg"></i>
                </button>
            </div>
        </div>
        <!-- Opciones de búsqueda -->
        <div class="opcionesBusqueda d-flex justify-content-center" role="group" aria-label="Opciones de búsqueda">
            <button type="button" class="btn" id="search-all">Todo</button>
            <button type="button" class="btn" id="search-genre">Género</button>
            <button type="button" class="btn" id="search-author">Autor</button>
        </div>
    </form>
    <div id="resultados" class="row p-4">
        <!-- Aquí se cargarán los resultados de la búsqueda -->
    </div>
</div>