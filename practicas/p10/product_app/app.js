// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
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

    // Si es numérico, asumimos que es un ID; de lo contrario, es una búsqueda general
    var parametros = isNaN(termino) ? { q: termino } : { id: termino };
    realizarBusqueda(parametros);
}

// FUNCIÓN GENÉRICA PARA REALIZAR BÚSQUEDAS
function realizarBusqueda(parametros) {
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE] Respuesta recibida:\n' + client.responseText);
            try {
                let productos = JSON.parse(client.responseText);

                // Si la respuesta es un solo objeto en lugar de un array, lo convertimos a array
                if (!Array.isArray(productos)) {
                    productos = [productos];
                }

                mostrarProductos(productos);
            } catch (error) {
                console.error("Error al procesar la respuesta del servidor:", error);
                mostrarProductos([]);
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
        tabla.innerHTML = "<tr><td colspan='3'>No se encontraron productos.</td></tr>";
    }
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();
    var productoJsonString = document.getElementById('description').value;
    var finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = document.getElementById('name').value;
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };

    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;
    try {
        objetoAjax = new XMLHttpRequest();
    } catch (err1) {
        try {
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

// FUNCIÓN PARA INICIALIZAR EL FORMULARIO
function init() {
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
}
