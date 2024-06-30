<!-- Footer -->
<footer class="mi-footer text-white py-4">
        <div class="container pt-2 pe-5">
            <div class="row">
                <!-- Logo y nombre de la aplicación -->
                <div class="col-md-3 mb-3 logo-footer">
                    <img src="comun/img/logo.png" alt="Logo" class="img-fluid mb-2">
                    <h5>Alejandría</h5>
                </div>
                <!-- Enlaces de la empresa -->
                <div class="col-md-3">
                    <h5>Empresa</h5>
                    <ul class="list-unstyled">
                        <li><a href="vistas/secciones/politica.html" target="_blank">Política de Privacidad</a></li>
                        <li><a href="index.php?controller=acceso_controlador&action=mostrar_terminos" target="_blank">Términos de Servicio</a></li>
                        <li><a href="vistas/secciones/contacto.php" target="_blank">Contacto</a></li>
                    </ul>
                </div>
                <!-- Redes sociales -->
                <div class="col-md-3">
                    <h5>Redes Sociales</h5>
                    <a href="https://www.instagram.com/" target="_blank" class="mr-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="https://x.com/?lang=es" target="_blank" class="mr-3"><i class="fab fa-x fa-lg"></i></a>
                    <a href="https://es.linkedin.com/" target="_blank" class="mr-3"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
                <!-- Mapa de Google Maps -->
                <div class="col-md-3">
                    <h5>Ubicación</h5>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6258.208863259856!2d-0.4982283883875932!3d38.346564878899855!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd623651dc56271b%3A0x44d1541559a417c5!2sIG%20Formaci%C3%B3n!5e0!3m2!1ses!2ses!4v1717928942313!5m2!1ses!2ses" 
                            width="100%" 
                            height="150" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>
<!-- GLOBALES -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!-- <script src="scripts/principal.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script type="module" src="scripts/menu.js"></script>
<?php
// Cargar scripts específicos según la vista actual
switch ($controller->view) {
    case 'login':
        echo '<script type="module" src="scripts/login.js"></script>';
        break;
    case 'registro':
        echo '<script type="module" src="scripts/registro.js"></script>';
        break;
    case 'buscar':
        echo '<script type="module" src="scripts/buscar.js"></script>';
        break;
    case 'listado_libros':
        echo '<script type="module" src="scripts/libros.js"></script>';
        break;
    case 'lista_contenido':
        echo '<script type="module" src="scripts/lista_contenido.js"></script>';
        break;
    case 'libro_info':
        echo '<script type="module" src="scripts/libro_info.js"></script>';
        break;
    case 'comentario_crear':
        echo '<script type="module" src="scripts/comentarios.js"></script>';
        break;
    case 'configuracion':
        echo '<script type="module" src="scripts/configuracion.js"></script>';
        break;
}
?>
</body>

</html>