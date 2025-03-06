// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $("#description").val(JsonString);

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

// FUNCIÓN CALLBACK AL CARGAR LA PÁGINA O AL AGREGAR UN PRODUCTO
function listarProductos() {
    // SE REALIZA LA PETICIÓN AJAX
    $.ajax({
        url: './backend/product-list.php',
        method: 'GET',
        dataType: 'json',
        success: function(productos) {
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if (productos.length > 0) {
                // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                let template = '';

                productos.forEach(producto => {
                    // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "products"
                $("#products").html(template);
            }
        }
    });
}

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
// FUNCIÓN CALLBACK DE BÚSQUEDA DE PRODUCTO CON ACTUALIZACIÓN AL TECLAR
function buscarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var search = $('#search').val();

    // Verificamos si el campo de búsqueda no está vacío
    if (search.trim() === "") {
        // Si está vacío, mostramos todos los productos
        listarProductos();
        return;
    }

    // SE REALIZA LA PETICIÓN AJAX
    $.ajax({
        url: './backend/product-search.php',
        method: 'GET',
        data: { search: search },
        dataType: 'json',
        success: function(productos) {
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if (productos.length > 0) {
                let template = '';
                let template_bar = '';

                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;

                    template_bar += `
                        <li>${producto.nombre}</il>
                    `;
                });

                // SE HACE VISIBLE LA BARRA DE ESTADO
                $("#product-result").removeClass("d-none").addClass("d-block");
                $("#container").html(template_bar);
                $("#products").html(template);
            } else {
                // Si no se encuentra ningún producto, mostrar un mensaje
                $("#products").html("<tr><td colspan='4'>No se encontraron productos.</td></tr>");
            }
        }
    });
}

// Asignamos el evento 'input' al campo de búsqueda para realizar la búsqueda mientras se escribe
$('#search').on('input', function(e) {
    buscarProducto(e);
});


// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = $('#description').val();
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = $('#name').val();
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    /**
     * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
     * ...
     * 
     * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
     */

    // SE REALIZA LA PETICIÓN AJAX
    $.ajax({
        url: './backend/product-add.php',
        method: 'POST',
        contentType: 'application/json',
        data: productoJsonString,
        dataType: 'json',
        success: function(respuesta) {
            let template_bar = '';
            template_bar += `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;

            // SE HACE VISIBLE LA BARRA DE ESTADO
            $("#product-result").removeClass("d-none").addClass("d-block");
            $("#container").html(template_bar);

            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
        }
    });
}

// FUNCIÓN CALLBACK DE BOTÓN "Eliminar"
function eliminarProducto() {
    if (confirm("De verdad deseas eliinar el Producto")) {
        var id = $(event.target).closest('tr').attr("productId");

        // SE REALIZA LA PETICIÓN AJAX
        $.ajax({
            url: './backend/product-delete.php',
            method: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(respuesta) {
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;

                // SE HACE VISIBLE LA BARRA DE ESTADO
                $("#product-result").removeClass("d-none").addClass("d-block");
                $("#container").html(template_bar);

                // SE LISTAN TODOS LOS PRODUCTOS
                listarProductos();
            }
        });
    }
}
