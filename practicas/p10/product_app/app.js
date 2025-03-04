// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "nombre": "",
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK PARA BUSCAR PRODUCTOS POR ID O TEXTO
function buscarProducto(e) {
    e.preventDefault();
    var termino = document.getElementById('search').value.trim();

    if (termino === "") {
        alert("Por favor ingresa un ID, nombre, marca o detalles para buscar.");
        return;
    }

    var parametros = isNaN(termino) ? { q: termino } : { id: termino };
    realizarBusqueda(parametros);
}

// FUNCIÓN GENÉRICA PARA REALIZAR BÚSQUEDAS
function realizarBusqueda(parametros) {
    var client = new XMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    client.onreadystatechange = function () {
        if (client.readyState == 4) {
            if (client.status == 200) {
                try {
                    let productos = JSON.parse(client.responseText);

                    if (!Array.isArray(productos)) {
                        productos = [productos];
                    }

                    mostrarProductos(productos);
                } catch (error) {
                    console.error("Error al procesar la respuesta del servidor:", error);
                    alert("Error al procesar la respuesta del servidor.");
                    mostrarProductos([]);
                }
            } else {
                alert("Error en la solicitud. Código: " + client.status);
            }
        }
    };

    var params = Object.keys(parametros)
        .map(key => key + '=' + encodeURIComponent(parametros[key]))
        .join('&');

    client.send(params);
}

// FUNCIÓN PARA MOSTRAR LOS PRODUCTOS EN LA TABLA
function mostrarProductos(productos) {
    let tabla = document.getElementById("productos");
    tabla.innerHTML = "";

    if (productos.length > 0) {
        productos.forEach(producto => {
            let descripcion = `
                <ul>
                    <li>Precio: ${producto.precio}</li>
                    <li>Unidades: ${producto.unidades}</li>
                    <li>Modelo: ${producto.modelo}</li>
                    <li>Marca: ${producto.marca}</li>
                    <li>Detalles: ${producto.detalles}</li>
                </ul>`;

            let fila = `
                <tr>
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${descripcion}</td>
                </tr>`;
            tabla.innerHTML += fila;
        });
    } else {
        tabla.innerHTML = "<tr><td colspan='3'> No se encontraron productos.</td></tr>";
    }
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();
    try {
        var nombre = document.getElementById('name').value.trim();
        var productoJsonString = document.getElementById('description').value.trim();

        if (nombre === "") {
            alert(" El nombre del producto no puede estar vacío.");
            return;
        }

        var finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = nombre;

        finalJSON['precio'] = parseFloat(finalJSON['precio']);
        finalJSON['unidades'] = parseInt(finalJSON['unidades']);

        if (isNaN(finalJSON['precio']) || finalJSON['precio'] <= 0) {
            alert("⚠️ El precio debe ser un número válido y mayor a 0.");
            return;
        }

        if (isNaN(finalJSON['unidades']) || finalJSON['unidades'] < 0) {
            alert("⚠️ Las unidades deben ser un número válido y mayor o igual a 0.");
            return;
        }

        if (!finalJSON.hasOwnProperty('imagen')) {
            finalJSON['imagen'] = "img/default.png";
        }

        productoJsonString = JSON.stringify(finalJSON, null, 2);

        var client = new XMLHttpRequest();
        client.open('POST', './backend/create.php', true);
        client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");

        client.onreadystatechange = function () {
            if (client.readyState == 4) {
                if (client.status == 200) {
                    try {
                        let respuesta = JSON.parse(client.responseText);
                        if (respuesta.success) {
                            alert("✅ Producto agregado correctamente. ID: " + respuesta.id);
                        } else {
                            alert("⚠️ Error: " + (respuesta.mensaje || "Error desconocido en el servidor."));
                        }
                    } catch (error) {
                        console.error("Error en la respuesta del servidor:", client.responseText);
                        alert(" Error en la respuesta del servidor.");
                    }
                } else {
                    alert("Error en la solicitud. Código: " + client.status);
                }
            }
        };

        client.send(productoJsonString);
    } catch (error) {
        alert(" Error al procesar los datos. Verifica el JSON.");
    }
}

// FUNCIÓN PARA INICIALIZAR EL FORMULARIO
function init() {
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
}
