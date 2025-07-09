<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Datos de conexión
$host = "34.135.137.46"; 
$user = "root"; 
$password = "123456"; 
$database = "practica";

// Conexión a la base de datos
$conexion = mysqli_connect($host, $user, $password, $database);

// Verificar conexión
if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}

// Consulta con separación de teléfonos
$consulta = "SELECT 
    p.nombre,
    p.apellido,
    p.correo,
    p.fecha_nacimiento,
    o.descripcion AS origen,
    SUBSTRING_INDEX(p.telefonos, ',', 1) AS telefono1,
    CASE 
        WHEN p.telefonos LIKE '%,%' THEN TRIM(SUBSTRING_INDEX(p.telefonos, ',', -1))
        ELSE NULL
    END AS telefono2
  FROM Paciente p
  JOIN Proviene o ON p.id_origen = o.id_origen";

// Ejecutar consulta
$resultado = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>DATOS PERSONALES DE Giancarlo Choque</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
    crossorigin="anonymous">
</head>
<body>
  <div class="container mt-5">
    <h1 class="display-4 text-center">DATOS PERSONALES DE Giancarlo Choque Niquin</h1>
    <hr>

    <?php
    if ($resultado && mysqli_num_rows($resultado) > 0): ?>
      <table class='table table-bordered table-striped mt-4'>
        <thead class='thead-dark'>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Fecha de Nacimiento</th>
            <th>Proviene</th>
            <th>Teléfono 1</th>
            <th>Teléfono 2</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
          <tr>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['apellido']) ?></td>
            <td><?= htmlspecialchars($fila['correo']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_nacimiento']) ?></td>
            <td><?= htmlspecialchars($fila['origen']) ?></td>
            <td><?= htmlspecialchars($fila['telefono1']) ?></td>
            <td><?= htmlspecialchars($fila['telefono2']) ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class='text-danger text-center'>No se encontraron registros de personas.</p>
    <?php endif; ?>

  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
    crossorigin="anonymous"></script>
</body>
</html>

