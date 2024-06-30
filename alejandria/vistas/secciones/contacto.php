<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto - Alejandría</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #FFF8EE;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
            border-color: #BD871F;
        }

        .form-control:focus {
            border-color: #343a40;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #402E32;
            border-color: #D2B48C;
            color: white;
        }

        .btn-primary:hover {
            background-color: #D2B48C;
            border-color: #402E32;
            color: black;
        }
    </style>
</head>

<body>

    <div class="container mt-5 p-5">
        <h1 class="mb-4">Contáctanos</h1>
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Tu nombre">
                </div>
                <div class="form-group col-md-6">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" placeholder="Tu correo electrónico">
                </div>
            </div>
            <div class="form-group">
                <label for="asunto">Asunto</label>
                <input type="text" class="form-control" id="asunto" placeholder="Asunto de tu mensaje">
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea class="form-control" id="mensaje" rows="5" placeholder="Escribe tu mensaje aquí"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>