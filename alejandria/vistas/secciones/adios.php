<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasta la vista!</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .farewell-container {
            text-align: center;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .farewell-container h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .farewell-container p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .farewell-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .btn-back {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 30px;
        }
        .btn-back:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="farewell-container">
    <iframe src="https://giphy.com/embed/NFA61GS9qKZ68" width="480" height="269" style="" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/reading-dot-strategies-NFA61GS9qKZ68">via GIPHY</a></p>
        <h1>¡No dejes de leer!</h1>
        <p>Nos entristece verte partir. Esperamos que vuelvas pronto, ¡tu cuenta siempre tendrá un lugar en nuestro corazón!</p>
        <a href="index.php?controller=acceso_controlador&action=registrar" class="btn btn-back">Volver a la página principal</a>
</body>
</html>
