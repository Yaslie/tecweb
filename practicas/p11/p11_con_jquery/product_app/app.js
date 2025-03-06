// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function() {
    init();

    // Cargar productos al abrir la página
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                var productos = JSON.parse(response);
                if (productos.length > 0) {
                    var template = '';
                    productos.forEach(function(producto) {
                        if (!producto.eliminado) { // Solo productos no eliminados
                            var descripcion = `
                                <li>precio: ${producto.precio}</li>
                                <li>unidades: ${producto.unidades}</li>
                                <li>modelo: ${producto.modelo}</li>
                                <li>marca: ${producto.marca}</li>
                                <li>detalles: ${producto.detalles}</li>
                            `;
                            template += `
                                <tr productId="${producto.id}">
                                    <td>${producto.id}</td>
                                    <td>${producto.nombre}</td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-delete btn btn-danger" onclick="eliminarProducto(${producto.id})">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }
                    });
                    $('#products').html(template);
                }
            }
        });
    }

    // Función de búsqueda de productos
    $('#search').on('input', function() {
        var searchQuery = $(this).val();
        $.ajax({
            url: './backend/product-search.php',
            type: 'GET',
            data: { search: searchQuery },
            success: function(response) {
                var productos = JSON.parse(response);
                var template = '';
                var templateBar = '';

                if (productos.length > 0) {
                    productos.forEach(function(producto) {
                        if (!producto.eliminado) {
                            var descripcion = `
                                <li>precio: ${producto.precio}</li>
                                <li>unidades: ${producto.unidades}</li>
                                <li>modelo: ${producto.modelo}</li>
                                <li>marca: ${producto.marca}</li>
                                <li>detalles: ${producto.detalles}</li>
                            `;
                            template += `
                                <tr productId="${producto.id}">
                                    <td>${producto.id}</td>
                                    <td>${producto.nombre}</td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-delete btn btn-danger" onclick="eliminarProducto(${producto.id})">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            `;
                            templateBar += `<li>${producto.nombre}</li>`;
                        }
                    });

                    $('#product-result').addClass('card my-4 d-block');
                    $('#container').html(templateBar);
                    $('#products').html(template);
                }
            }
        });
    });

    // Función para agregar un producto
    $('#add-product').on('click', function(e) {
        e.preventDefault();
        var productoJsonString = $('#description').val();
        var producto = JSON.parse(productoJsonString);
        producto['nombre'] = $('#name').val();

        $.ajax({
            url: './backend/product-add.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(producto),
            success: function(response) {
                var respuesta = JSON.parse(response);
                var templateBar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $('#product-result').addClass('card my-4 d-block');
                $('#container').html(templateBar);

                // Cargar lista actualizada de productos
                listarProductos();
            }
        });
    });

    // Función para eliminar un producto
    window.eliminarProducto = function(id) {
        if (confirm("De verdad deseas eliminar el Producto?")) {
            $.ajax({
                url: './backend/product-delete.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    var respuesta = JSON.parse(response);
                    var templateBar = `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
                    $('#product-result').addClass('card my-4 d-block');
                    $('#container').html(templateBar);

                    // Cargar lista actualizada de productos
                    listarProductos();
                }
            });
        }
    };

    // Inicializar lista de productos al cargar la página
    function init() {
        var JsonString = JSON.stringify(baseJSON, null, 2);
        $('#description').val(JsonString);

        // Cargar productos al inicio
        listarProductos();
    }
});
