var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

let editar = false;

function init() {
    // Ocultamos el cuadro de product-result siempre
    $('#product-result').hide();

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
    agregarProducto();
    buscarProducto();
    eliminarProducto();
    editarProducto();
}

$(document).ready(function() {
    // Función para listar productos
    function listarProductos() {
        $.ajax({
            url: 'backend/controllers/ProductController.php?action=list', // Apunta al controlador ProductController.php
            type: 'GET',
            success: function(response) {
                console.log("Response de listar productos:", response); // Alerta para depuración
                let products = JSON.parse(response);
                let template = '';
                products.forEach(product => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + product.precio + '</li>';
                    descripcion += '<li>unidades: ' + product.unidades + '</li>';
                    descripcion += '<li>modelo: ' + product.modelo + '</li>';
                    descripcion += '<li>marca: ' + product.marca + '</li>';
                    descripcion += '<li>detalles: ' + product.detalles + '</li>';

                    template += `<tr productId="${product.id}">
                        <td>${product.id}</td>
                        <td>
                            <a href="#" class="product-item">${product.nombre}</a>
                        </td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>`;
                });
                $('#products').html(template);
            },
            error: function(xhr, status, error) {
                alert("Error al listar productos: " + error);
                console.error("Error al listar productos:", error); // Alerta de error para depuración
            }
        });
    }

    // Llamar a la función para listar los productos cuando cargue la página
    listarProductos();
});


function buscarProducto() {
    $('#product-result').hide();
    $('#search').keyup(function(e) {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: 'backend/controllers/ProductController.php?action=search', // Cambié esto
                type: 'GET',
                data: { search },
                success: function(response) {
                    console.log("Response de buscar productos:", response); // Alerta para depuración
                    let products = JSON.parse(response);
                    let template = '';
                    products.forEach(product => {
                        template += `<li>${product.nombre}</li>`;
                    });
                    $('#container').html(template);
                    if (template) {
                        $('#product-result').show();
                    } else {
                        $('#product-result').hide();
                    }

                    let productTableTemplate = '';
                    products.forEach(product => { 
                        let descripcion = '';
                        descripcion += '<li>precio: ' + product.precio + '</li>';
                        descripcion += '<li>unidades: ' + product.unidades + '</li>';
                        descripcion += '<li>modelo: ' + product.modelo + '</li>';
                        descripcion += '<li>marca: ' + product.marca + '</li>';
                        descripcion += '<li>detalles: ' + product.detalles + '</li>';

                        productTableTemplate += `<tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td><a href="#" class="product-item">${product.nombre}</a></td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>`;
                    });
                    $('#products').html(productTableTemplate);
                },
                error: function(xhr, status, error) {
                    alert("Error al buscar productos: " + error);
                    console.error("Error al buscar productos:", error); // Alerta de error para depuración
                }
            });
        }
    });
}

function agregarProducto() {
    $('#product-form').submit(function(e) {
        e.preventDefault();
        const postData = {
            id: $('#product-Id').val(),
            nombre: $('#name').val().trim(),
            marca: $('#form-marca').val(),
            modelo: $('#form-modelo').val().trim(),
            precio: $('#form-precio').val(),
            unidades: $('#form-unidades').val(),
            detalles: $('#form-detalles').val(),
            imagen: $('#form-imagen').val()
        };

        const jsonPostData = JSON.stringify(postData);

        let url = editar === false ? 'backend/controllers/ProductController.php?action=add' : 'backend/controllers/ProductController.php?action=edit';
        
        $.post(url, jsonPostData, function(response) {
            console.log("Response de agregar producto:", response); // Alerta para depuración
            let result = typeof response === 'string' ? JSON.parse(response) : response;
            if (result.status === "success") {
                alert("Registro exitoso");
                listarProductos();
                $('#product-form').trigger('reset');
                $('#description').val(JSON.stringify(baseJSON, null, 2));
                editar = false;
            } else {
                alert(result.message);
            }
        }).fail(function(xhr, status, error) {
            alert("Error al agregar producto: " + error);
            console.error("Error al agregar producto:", error); // Alerta de error para depuración
        });
    });
}

function eliminarProducto() {
    $(document).on('click', '.product-delete', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        if (confirm(`¿Estás seguro de eliminar el producto con ID: ${id}?`)) {
            $.get('backend/controllers/ProductController.php?action=delete', { id }, function(response) {
                console.log("Response de eliminar producto:", response); // Alerta para depuración
                let result = JSON.parse(response);
                if (result.status === "success") {
                    alert("Eliminado exitosamente");
                    listarProductos();
                } else {
                    alert("Error al eliminar el producto: " + result.message);
                }
            }).fail(function(xhr, status, error) {
                alert("Error al eliminar producto: " + error);
                console.error("Error al eliminar producto:", error); // Alerta de error para depuración
            });
        }
    });
}

function editarProducto() {
    $(document).on('click', '.product-item', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        $.post('backend/controllers/ProductController.php?action=single', { id }, function(response) {
            console.log("Response de editar producto:", response); // Alerta para depuración
            const producto = JSON.parse(response);
            $('#name').val(producto.nombre);
            $('#product-Id').val(producto.id);
            $('#form-marca').val(producto.marca);
            $('#form-modelo').val(producto.modelo);
            $('#form-precio').val(producto.precio);
            $('#form-unidades').val(producto.unidades);
            $('#form-detalles').val(producto.detalles);
            $('#form-imagen').val(producto.imagen);
            editar = true;
        }).fail(function(xhr, status, error) {
            alert("Error al editar producto: " + error);
            console.error("Error al editar producto:", error); // Alerta de error para depuración
        });
    });
}
