var table_type;
$(document).ready(function() {


    //TIPO CLIENTES
    var dataSetType;
    $.ajax({
        url: "/client/type_list",
        type: 'GET',
        data: "",
        success: function(data) {
            dataSetType = data;
            var table_type = $('#type_clients').DataTable();
            $.each(data, function(i, dat) {

                table_type.row.add([dat.id, dat.name])
                    .draw()
                    .node().id = dat.id;

            });


        },
        error: function(xhr) {
            console.log(xhr.responseText);
        },
    });
    //Table Tipo de cliente
    table_type = $('#type_clients').DataTable({
        data: dataSetType,
        render: function(data, type, full, meta) {
            Utils.formatString(buttonTemplate, data)
        },

        columns: [
            { title: "Id" },
            { title: "Nombre" },
            { title: "Acciones" }

        ],
        columnDefs: [{
            render: createTypeBtn,
            data: dataSetType,
            targets: [2]
        }],

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

    $('#type_clients tbody').on('click', '#editTypeBtn', function() {
        var data = table_type.row($(this).parents('tr')).data();

        $("#typeModal").modal("show");
        $("#title-modal").text("Editar tipo de cliente");
        $('#formRegisterType').attr('action', '/client/type_edit/' + data[0]);
        $("#name").val(data[1]);

    });


    $('#type_clients tbody').on('click', '#questionBtn', function() {
        var data = table_type.row($(this).parents('tr')).data();

        $("#QuestionModal").modal("show");
        $("#modal-title-question").text("Registrar preguntas - Tipo " + data[1]);
        id = data[0];

        $('#formRegisterType').attr('action', '/client/type_edit/' + id);

        $('#btnRegisterQuestion').attr('onclick', 'btnRegisterQuestion()');
        $('#btnEditQuestion').attr('onclick', 'btnEditQuestion()');
        $('#btnSaveQuestion').attr('onclick', 'btnSaveQuestion(' + id + ')');
        $('#btnEditSaveQuestion').attr('onclick', 'btnEditSaveQuestion()');
        $('#btnCloseQuestion').attr('onclick', 'btnCloseQuestion()');
        $('#btnDeleteQuestion').attr('onclick', 'btnDeleteQuestion()');
        allQuestion(id, 0);
    });

    $('#type_clients tbody').on('click', '#deleteTypeBtn', function() {
        var data = table_type.row($(this).parents('tr')).data();
        table_type.row("tr[id=" + data[0] + "]").remove().draw(false);

        $.ajax({
            url: '/client/type_delete/' + data[0],
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
                    allQuestion(id, 0);
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

    //Tabla Clientes

    $('#type_clients tbody').on('click', '#editTypeBtn', function() {
        var data = table_type.row($(this).parents('tr')).data();





    });



    //fin 
});


//Clients
function registrarTypeModal() {
    $("#typeModal").modal("show");
    $("#title-modal").text("Registrar tipo de cliente");
    $('#formRegisterType').attr('action', '/client/type_register');
    $("#name").val("");
}

function createTypeBtn(dataSet) {
    return ' <button id="questionBtn" type="button"  class="btn btn-info btn-sm"><i class="fas fa-plus"></i></button>   <button id="editTypeBtn" type="button"  class="btn btn-secondary btn-sm" style="margin-left: 0.5rem;"><i class="fas fa-edit"></i></button>   <button id="deleteTypeBtn" type="button"  class="btn btn-danger btn-sm" style="margin-left: 0.5rem;"><i class="fas fa-trash"></i></button>';
}


function allQuestion(id, bol) {

    $.ajax({
        type: "GET",
        url: "/client/question_list/" + id + "/" + bol,
        data: {},
        success: function(data) {
            console.log(data);
            document.getElementById('question_select').innerHTML = "";
            var html = "";
            for (indice = 0; indice < data.preguntas.length; indice++) {

                html += '<option value="' + data.preguntas[indice].id + '" >' + data.preguntas[indice].question + '</option>';

            }

            $('#btnEditQuestion').prop("disabled", false);
            if (html == "") {
                html = '<option hidden>No existen preguntas</option>';
                $('#btnEditQuestion').prop("disabled", true);
            }
            $('#question_select').append(html);



        }
    });
}


function btnSaveQuestion(id) {

    prg = encodeURIComponent(document.getElementById('Agregarpreguntas').value);
    console.log("Entro");
    if ($('#Agregarpreguntas').val().length == 0) {
        prg = 1;
    }

    $.ajax({
        url: "/client/question_register/" + id + "/" + prg,
        type: 'GET',
        data: {},
        success: function(data) {
            toastr.options = {
                "debug": false,
                "newestOnTop": false,
                "positionClass": "toast-top-center",
                "closeButton": true,
                "toastClass": "animated fadeInDown",
            };

            if (data.status == 500) {
                toastr.error('Faltan datos.');
                $("#Agregarpreguntas" + id).val("");
            } else if (data.status == 200) {
                toastr.success('Datos guardados.');
                allQuestion(id, 0);
                btnCloseQuestion(id);


            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        },
    });



}


function btnEditSaveQuestion() {

    id = $("#question_select option:selected").val();
    var prg = encodeURIComponent(document.getElementById('Editarpreguntas').value);
    $.ajax({

        type: "GET",
        url: "/client/question_edit/" + id + "/" + prg,
        data: {},
        success: function(data) {
            console.log("editar prg" + id);

            toastr.options = {
                "debug": false,
                "newestOnTop": false,
                "positionClass": "toast-top-center",
                "closeButton": true,
                "toastClass": "animated fadeInDown",
            };

            if (data.status == 500) {
                toastr.error('Faltan datos.');
            } else if (data.status == 200) {
                toastr.success('Datos guardados.');
                allQuestion(id, 1);
                btnCloseQuestion(id);


            }
        }
    });



}

function btnDeleteQuestion() {

    id = $("#question_select option:selected").val();

    $.ajax({
        url: '/client/question_delete/' + id,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        data: {
            "id": id,
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
                allQuestion(id);
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

}


//Question action
function btnRegisterQuestion() {
    $("#Agregarpreguntas").val("");
    $("#Agregarpreguntas").text("");
    $('#btnDeleteQuestion').hide();
    $('#question_select').hide();
    $('#btnRegisterQuestion').hide();
    $('#btnEditQuestion').hide();
    $('#Agregarpreguntas').show();
    $('#btnSaveQuestion').show();
    $('#btnCloseQuestion').show();


}

function btnEditQuestion() {

    $("#Editarpreguntas").val($("#question_select option:selected").text());
    $('#btnDeleteQuestion').hide();
    $('#question_select').hide();
    $('#btnRegisterQuestion').hide();
    $('#btnEditQuestion').hide();
    $('#Editarpreguntas').show();
    $('#btnSaveQuestion').hide();
    $("#btnEditSaveQuestion").show();
    $('#btnCloseQuestion').show();



}

function btnCloseQuestion() {
    $('#btnDeleteQuestion').show();
    $('#question_select').show();
    $('#btnRegisterQuestion').show();
    $('#btnEditQuestion').show();
    $('#Agregarpreguntas').hide();
    $('#Editarpreguntas').hide();
    $('#btnSaveQuestion').hide();
    $("#btnEditSaveQuestion").hide();
    $('#btnCloseQuestion').hide();

}