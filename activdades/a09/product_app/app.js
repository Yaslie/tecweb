$(function () {
    let edit = false;
    console.log('jQuery is Working');
    $('#product-result').hide();
    listarProductos();

    // Buscar productos
    $('#search').keyup(function (e) {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: `backend/myapi/products/${search}`,
                type: 'GET',
                success: function (response) {
                    let products = JSON.parse(response);
                    let template = '';
                    products.forEach(product => {
                        let descripcion = '';
                        descripcion += '<li>precio: ' + product.precio + '</li>';
                        descripcion += '<li>unidades: ' + product.unidades + '</li>';
                        descripcion += '<li>modelo: ' + product.modelo + '</li>';
                        descripcion += '<li>marca: ' + product.marca + '</li>';
                        descripcion += '<li>detalles: ' + product.detalles + '</li>';
                        template += `
                            <tr productId="${product.id}">
                                <td>${product.id}</td>
                                <td>${product.nombre}</td>
                                <td>${descripcion}</td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                }
            });
        }
    });

    // Validar campos al perder el foco
    $('#name').blur(validateName);
    $('#marca').blur(validateMarca);
    $('#modelo').blur(validateModelo);
    $('#precio').blur(validatePrecio);
    $('#unidades').blur(validateUnidades);

    function validateName() {
        let name = $('#name').val();
        if (name === '' || name.length > 100) {
            $('#container').text('Nombre es requerido y debe tener 100 caracteres o menos.');
            $('#product-result').show();
            return false;
        }
        return true;
    }

    function validateMarca() {
        if ($('#marca').val() === '') {
            $('#container').text('Marca es requerida.');
            $('#product-result').show();
            return false;
        }
        return true;
    }

    function validateModelo() {
        let modelo = $('#modelo').val();
        if (modelo === '' || modelo.length > 25) {
            $('#container').text('Modelo es requerido y debe tener 25 caracteres o menos.');
            $('#product-result').show();
            return false;
        }
        return true;
    }

    function validatePrecio() {
        let precio = parseFloat($('#precio').val());
        if (isNaN(precio) || precio <= 99.99) {
            $('#container').text('Precio es requerido y debe ser mayor a 99.99.');
            $('#product-result').show();
            return false;
        }
        return true;
    }

    function validateUnidades() {
        let unidades = parseInt($('#unidades').val());
        if (isNaN(unidades) || unidades < 0) {
            $('#container').text('Unidades son requeridas y deben ser mayores o iguales a 0.');
            $('#product-result').show();
            return false;
        }
        return true;
    }

    // Agregar o editar producto
    $('#product-form').submit(function (e) {
        e.preventDefault();
        if (!validateName() || !validateMarca() || !validateModelo() || !validatePrecio() || !validateUnidades()) {
            $('#container').text('Por favor, corrige los errores antes de enviar.');
            $('#product-result').show();
            return;
        }

        const postData = {
            nombre: $('#name').val(),
            marca: $('#marca').val(),
            modelo: $('#modelo').val(),
            precio: parseFloat($('#precio').val()),
            detalles: $('#detalles').val(),
            unidades: parseInt($('#unidades').val()),
            imagen: $('#imagen').val(),
            id: $('#product-id').val()
        };

        const url = edit ? 'backend/myapi/product' : 'backend/myapi/product';
        const method = edit ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(postData),
            contentType: 'application/json',
            success: function (response) {
                const res = JSON.parse(response);
                $('#container').text(res.message);
                $('#product-result').show();
                if (res.status === "success") {
                    listarProductos();
                    $('#product-form').trigger('reset');
                }
            },
            error: function () {
                $('#container').text('Error al agregar o editar el producto.');
                $('#product-result').show();
            }
        });
    });

    // Listar productos
    function listarProductos() {
        $.ajax({
            url: 'backend/myapi/products',
            type: 'GET',
            success: function (response) {
                let products = JSON.parse(response);
                let template = '';
                products.forEach(product => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + product.precio + '</li>';
                    descripcion += '<li>unidades: ' + product.unidades + '</li>';
                    descripcion += '<li>modelo: ' + product.modelo + '</li>';
                    descripcion += '<li>marca: ' + product.marca + '</li>';
                    descripcion += '<li>detalles: ' + product.detalles + '</li>';
                    template += `
                        <tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td>
                                <a href="#" class="product-item"> ${product.nombre} </a>
                            </td>
                            <td>${descripcion}</td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#products').html(template);
            }
        });
    }

    // Eliminar un producto
    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Estás seguro de que deseas eliminarlo?')) {
            const element = e.currentTarget.closest('tr');
            const id = $(element).attr('productId');
            $.ajax({
                url: `backend/myapi/product/${id}`,
                type: 'DELETE',
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === "success") {
                        $('#container').html(res.message);
                        $('#product-result').show();
                        listarProductos();
                    } else {
                        $('#container').html(res.message);
                        $('#product-result').show();
                    }
                }
            });
        }
    });

    // Obtener un producto por ID
    $(document).on('click', '.product-item', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');

        $.ajax({
            url: `backend/myapi/product/${id}`,
            type: 'GET',
            success: function (response) {
                const product = JSON.parse(response);
                if (product.status === 'success') {
                    $('#name').val(product.producto.nombre);
                    $('#marca').val(product.producto.marca);
                    $('#modelo').val(product.producto.modelo);
                    $('#precio').val(product.producto.precio);
                    $('#detalles').val(product.producto.detalles);
                    $('#unidades').val(product.producto.unidades);
                    $('#imagen').val(product.producto.imagen);
                    $('#product-id').val(product.producto.id);
                    edit = true;
                } else {
                    $('#container').html(product.message);
                    $('#product-result').show();
                }
            }
        });
    });
});

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
}


