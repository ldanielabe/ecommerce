$(document).ready(function() {

    var dataSet;
    $.ajax({
        url: "/product/list",
        type: 'GET',
        data: "",
        success: function(data) {
            dataSet = data;
            var table = $('#product_table').DataTable();
            $.each(data, function(i, dat) {

                if (dat.id != 0) {
                    table.row.add([dat.id, dat.name, dat.price, dat.stock])
                        .draw()
                        .node().id = dat.id;
                }
            });


        },
        error: function(xhr) {
            console.log(xhr.responseText);
        },
    });


    var table = $('#product_table').DataTable({
        data: dataSet,
        render: function(data, type, full, meta) {
            Utils.formatString(buttonTemplate, data)
        },

        columns: [
            { title: "Id" },
            { title: "Nombre" },
            { title: "Precio" },
            { title: "Stock" },
            { title: "Acciones" }

        ],
        columnDefs: [{
                render: createManageBtn,
                data: dataSet,
                targets: [4]
            },
            {
                "targets": [0],
                "visible": false
            }
        ],

        //para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });

    $('#product_table tbody').on('click', '#editProductBtn', function() {
        var data = table.row($(this).parents('tr')).data();

        $("#productModal").modal("show");
        $("#title-modal").text("Editar producto");
        $('#formRegisterProduct').attr('action', '/product/edit/' + data[0]);
        $("#name").val(data[1]);
        $("#proce").val(data[2]);
        $("#stock").val(data[3]);




    });

    $('#product_table tbody').on('click', '#deleteProductBtn', function() {
        var data = table.row($(this).parents('tr')).data();
        table.row("tr[id=" + data[0] + "]").remove().draw(false);

        $.ajax({
            url: '/product/delete/' + data[0],
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            data: {
                "id": data[0],
                "_method": 'DELETE',
            },
            success: function(data) {

                if (data == 200) {

                    toastr.options = {
                        "debug": false,
                        "newestOnTop": false,
                        "positionClass": "toast-top-center",
                        "closeButton": true,
                        "toastClass": "animated fadeInDown",
                    };

                    toastr.success('Se elimino correctamente.');

                } else {
                    toastr.options = {
                        "debug": false,
                        "newestOnTop": false,
                        "positionClass": "toast-top-center",
                        "closeButton": true,
                        "toastClass": "animated fadeInDown",
                    };

                    toastr.error('Error, elimine nuevamente.');
                }


            },
            error: function(xhr) {
                console.log(xhr.responseText);
            },
        });
    });



    //fin 
});

function registrarProductModal() {
    $("#productModal").modal("show");
    $("#title-modal").text("Registrar producto");
    $('#formRegisterProduct').attr('action', '/product/register');

    $("#name").val("");
    $("#price").val("");
    $("#stock").val("");
}

function createManageBtn(dataSet) {
    return '<button id="editProductBtn" type="button"  class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></button><button id="deleteProductBtn" type="button"  class="btn btn-danger btn-sm" style="margin-left: 1rem;"><i class="fas fa-trash"></i></button>';
}