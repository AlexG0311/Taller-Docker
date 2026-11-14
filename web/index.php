<?php
// Zona horaria de Colombia
date_default_timezone_set('America/Bogota');

// Datos de conexión obtenidos desde Docker Compose
$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

$conexion = null;
$estado = false;
$mensaje_error = '';

try {
    // Conexión con MySQL
    $conexion = new mysqli(
        $db_host,
        $db_user,
        $db_pass,
        $db_name
    );

    $conexion->set_charset("utf8mb4");
    $estado = true;

} catch (mysqli_sql_exception $e) {
    $mensaje_error = "No se pudo conectar con la base de datos.";
}

// Consultar estudiantes
$estudiantes = [];

if ($estado) {
    $resultado = $conexion->query(
        "SELECT id, nombre, programa FROM estudiantes"
    );

    while ($fila = $resultado->fetch_assoc()) {
        $estudiantes[] = $fila;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Docker - Alex y Roger</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, sans-serif;
            background: #eef2f7;
            color: #263238;
        }

        .contenedor {
            max-width: 850px;
            margin: 30px auto;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        h1 {
            color: #1565c0;
            text-align: center;
        }

        h2 {
            color: #263238;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
            margin-top: 30px;
        }

        .bienvenida {
            text-align: center;
            line-height: 1.7;
        }

        .estado {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .conectado {
            background: #d4edda;
            color: #155724;
        }

        .desconectado {
            background: #f8d7da;
            color: #721c24;
        }

        .informacion {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            line-height: 1.8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1565c0;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f6fa;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>¡Bienvenidos a nuestro proyecto!</h1>

    <div class="bienvenida">
        <h3>Aplicación web desarrollada con Docker Compose</h3>

        <p>
            Desarrollada por <strong>Alex Gonzalez</strong>
            y <strong>Roger Mendoza</strong>.
        </p>

        <p>
            Estudiantes de Ingeniería de Sistemas.
        </p>
    </div>

    <h2>Información del servidor</h2>

    <div class="informacion">
        <strong>Fecha:</strong>
        <?= date('d/m/Y') ?>

        <br>

        <strong>Hora del servidor:</strong>
        <?= date('h:i:s A') ?>

        <br>

        <strong>Zona horaria:</strong>
        <?= date_default_timezone_get() ?>
    </div>

    <h2>Estado de la base de datos</h2>

    <?php if ($estado): ?>

        <div class="estado conectado">
            ✓ CONEXIÓN EXITOSA CON MYSQL
        </div>

        <p>
            La aplicación se encuentra conectada correctamente
            a la base de datos.
        </p>

        <h2>Estudiantes registrados</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Programa académico</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($estudiante['id']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($estudiante['nombre']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($estudiante['programa']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <div class="estado desconectado">
            ✗ ERROR DE CONEXIÓN CON MYSQL
        </div>

        <p><?= htmlspecialchars($mensaje_error) ?></p>

    <?php endif; ?>

    <footer>
        Taller de Docker - Actividad Evaluativa
        <br>
        Ingeniería de Sistemas
    </footer>

</div>

</body>
</html>

<?php
if ($conexion !== null) {
    $conexion->close();
}
?>