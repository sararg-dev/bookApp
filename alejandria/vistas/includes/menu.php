<div id="sidebar" class="d-flex flex-column">
    <div class="toggle-container d-flex align-items-center mb-3">
        <a href="index.php?controller=lista_controlador&action=mostrar_vista" class="mt-2 d-flex align-items-center">
            <img src="comun/img/logo.png" alt="Logo de la web">
            <h6 class="ml-2">Alejandría</h6>
        </a>
        <span id="toggleSidebar" class="text-white ml-3" title="Plegar menú"><i class="fa-solid fa-bars fa-xl"></i></span>
    </div>
    <hr>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="index.php?controller=buscar_controlador&action=mostrar_vista" class="nav-link">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <span>Descubrir</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="index.php?controller=libro_controlador&action=mostrar_vista" class="nav-link">
                <i class="fa-solid fa-book fa-xl"></i>
                <span>Mis libros</span>
            </a>
        </li>
        <li class="nav-item listas">
            <div class="nav-link-2">
                <i class="fa-solid fa-book-open-reader fa-xl"></i>
                <span>Mis listas</span>
                <span class="addList" title="Crear lista">
                    <i class="fa-solid fa-plus fa-xl"></i>
                </span>
            </div>
        </li>
    </ul>
    <div class="listadoListas">
        <!-- Aquí se cargarán las listas del usuario -->
    </div>
    <!-- INFORMACIÓN DEL USUARIO -->
    <div class="user-info d-flex align-items-center">
        <div class="d-flex align-items-center user-details-container">
            <img src="" alt="Foto de perfil" class="mr-3">
            <div class="user-details">
                <strong class="userName"></strong>
            </div>
        </div>
        <!-- Contenedor adicional para posicionar el menú desplegable -->
        <div class="dropdown-container">
            <!-- Menú desplegable del usuario -->
            <div class="dropdown">
                <i class="fa-solid fa-ellipsis-vertical fa-lg user-options-icon" id="userDropdownIcon" title="Ajustes de cuenta"></i>
                <div class="userDropdownMenu" aria-labelledby="userDropdownIcon">
                    <a class="dropdown-item" href="index.php?controller=acceso_controlador&action=mostrar_configuracion"><i class="fa-solid fa-user-pen"></i>Editar perfil</a>
                    <a class="dropdown-item" href="index.php?controller=acceso_controlador&action=cerrar_sesion"><i class="fa-solid fa-arrow-right-from-bracket"></i>Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>