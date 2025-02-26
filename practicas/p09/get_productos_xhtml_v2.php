<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
    <script>
        function modificarProducto(event) {
            var row = event.target.closest("tr");
            var data = row.querySelectorAll(".row-data");

            var id = data[0].textContent;
            var nombre = data[1].textContent;
            var marca = data[2].textContent;
            var modelo = data[3].textContent;
            var precio = data[4].textContent;
            var unidades = data[5].textContent;
            var detalles = data[6].textContent;
            var imagenes = row.querySelector("img").src;

            alert(
                "ID: " + id + "\n" +
                "Nombre: " + nombre + "\n" +
                "Marca: " + marca + "\n" +
                "Modelo: " + modelo + "\n" +
                "Precio: $" + precio + "\n" +
                "Unidades: " + unidades + "\n" +
                "Detalles: " + detalles
            );
            window.location.href = "formulario_productos_v2.html?id=" + id +
                "&nombre=" + encodeURIComponent(nombre) +
                "&marca=" + encodeURIComponent(marca) +
                "&modelo=" + encodeURIComponent(modelo) +
                "&precio=" + precio +
                "&unidades=" + unidades +
                "&detalles=" + encodeURIComponent(detalles) +
                "&imagenes=" + encodeURIComponent(imagenes);
        }
    </script>
</head>
<body>
    <h3>Lista de Productos</h3>
    <br/>

    <?php
    @$link = new mysqli('localhost', 'root', 'Alaskita123', 'marketzone');

    if ($link->connect_errno) {
        die('<div class="alert alert-danger">Falló la conexión: ' . $link->connect_error . '</div>');
    }

    if ($result = $link->query("SELECT * FROM productos")) {
        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead class="thead-dark">';
            echo '<tr><th>#</th><th>Nombre</th><th>Marca</th><th>Modelo</th><th>Precio</th><th>Unidades</th><th>Detalles</th><th>Imagen</th><th>Acciones</th></tr>';
            echo '</thead><tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="row-data">' . htmlspecialchars($row['id']) . '</td>';
                echo '<td class="row-data">' . htmlspecialchars($row['nombre']) . '</td>';
                echo '<td class="row-data">' . htmlspecialchars($row['marca']) . '</td>';
                echo '<td class="row-data">' . htmlspecialchars($row['modelo']) . '</td>';
                echo '<td class="row-data">' . htmlspecialchars($row['precio']) . '</td>';
                echo '<td class="row-data">' . htmlspecialchars($row['unidades']) . '</td>';
                echo '<td class="row-data">' . htmlspecialchars($row['detalles']) . '</td>';
                echo '<td><img src="' . htmlspecialchars($row['imagenes']) . '" width="100" height="100"/></td>';
                echo '<td><button class="btn btn-primary" onclick="modificarProducto(event)">Modificar</button></td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-warning">No hay productos disponibles.</div>';
        }
        $result->free();
    }

    $link->close();
    ?>
</body>
</html>
