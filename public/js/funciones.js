$(document).ready(function() {

    var dataSet;
    $.ajax({
        url: "/vendor/list",
        type: 'GET',
        data: "",
        success: function(data) {
            dataSet = data;
            var table = $('#vendor_table').DataTable();
            $.each(data, function(i, dat) {

                if (dat.id != 1) {
                    table.row.add([dat.id, dat.identification, dat.name, dat.address, dat.phone, dat.email])
                        .draw()
                        .node().id = dat.id;
                }
            });


        },
        error: function(xhr) {
            console.log(xhr.responseText);
        },
    });


    var table = $('#vendor_table').DataTable({
        data: dataSet,
        render: function(data, type, full, meta) {
            Utils.formatString(buttonTemplate, data)
        },

        columns: [
            { title: "Id" },
            { title: "Identificacion" },
            { title: "Nombre" },
            { title: "Dirección" },
            { title: "Celular" },
            { title: "Correo" },
            { title: "Acciones" }

        ],
        columnDefs: [{
                render: createManageBtn,
                data: dataSet,
                targets: [6]
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

    $('#vendor_table tbody').on('click', '#editVendorBtn', function() {
        var data = table.row($(this).parents('tr')).data();

        $("#vendorModal").modal("show");
        $("#title-modal").text("Editar vendedor");
        $('#formRegisterVendor').attr('action', '/vendor/edit/' + data[0]);
        $("#identification").val(data[1]);
        $("#name").val(data[2]);
        $("#address").val(data[3]);
        $("#phone").val(data[4]);
        $("#email").val(data[5]);
        $('#password').hide();
        $('#txt-password').hide();
        $('#password_confirm').hide();
        $('#txt-password-confirm').hide();



    });

    $('#vendor_table tbody').on('click', '#deleteVendorBtn', function() {
        var data = table.row($(this).parents('tr')).data();
        table.row("tr[id=" + data[0] + "]").remove().draw(false);

        $.ajax({
            url: '/vendor/delete/' + data[0],
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




    $('#vendor_table tbody').on('click', '#assignBtn', function() {
        var data = table.row($(this).parents('tr')).data();

        $("#AssignModal").modal("show");
        $("#modal-title-question").text("Asignar clientes - Vendedor/a " + data[2]);
        id = data[0];

        $('#btnRegisterAssign').on('click', function() {

            console.log(data);
            $select = $('#client_select');

            $select.children(':selected').each((idx, el) => {

                $.ajax({
                    type: "GET",
                    url: "/vendor/assign/" + id + "/" + el.value,
                    data: {},
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success('Datos guardados.');
                        }
                    }
                });
            });
        });

        $.ajax({
            type: "GET",
            url: "/client/list",
            data: {},
            success: function(data) {

                document.getElementById('client_select').innerHTML = "";
                var html = "";
                num = data.id_client;
                k = 1;

                for (i = 0; i < data.client.length; i++) {

                    if (data.client[i].id_client == k) {
                        html += '<option value="' + data.client[i].id_client + '" >' + data.client[i + 1].answer + '</option>';
                        k++;
                    }
                }

                if (html == "") {
                    document.getElementById('client_select').innerHTML = '<option value="" hidden> No existen clientes.</option>';
                }

                $('#client_select').append(html);
                $('.selectpicker').selectpicker('refresh');

            }
        });
    }); //fin ajax



    //fin 
});

function registrarVendorModal() {
    $("#vendorModal").modal("show");
    $("#title-modal").text("Registrar vendedor");
    $('#formRegisterVendor').attr('action', '/vendor/register');
    $("#identification").val("");
    $("#name").val("");
    $("#address").val("");
    $("#phone").val("");
    $("#email").val("");
}

function createManageBtn(dataSet) {
    return '<button id="assignBtn" type="button"  class="btn btn-info btn-sm"><i class="fas fa-exchange-alt"></i></button>   <button id="editVendorBtn" type="button"  class="btn btn-secondary btn-sm" style="margin-left: 0.5rem;"><i class="fas fa-edit"></i></button><button id="deleteVendorBtn" type="button"  class="btn btn-danger btn-sm" style="margin-left: 0.5rem;"><i class="fas fa-trash"></i></button>';
}