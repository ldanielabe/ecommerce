$(document).ready(function() {


    //registrar clientes
    $('#container').on('click', '#registrarClient', function() {
        $("#ClientModal").modal("show");
    });


    $('#client_select').on('click', function() {
        id = $("#client_select option:selected").val();
        allQuestionClient(id);
        $('#formRegisterClients').attr('action', '/client/register/' + id);
    });


});


//Register client

function register_client() {


}


function allQuestionClient(id) {

    $.ajax({
        type: "GET",
        url: "/client/all_question_client/" + id,
        data: {},
        success: function(data) {

            console.log(data);
            document.getElementById('form_register_client').innerHTML = "";
            var html = "";
            for (indice = 0; indice < data.length; indice++) {

                if (id == data[indice].id_type) {
                    html += '<label for="' + data[indice].question + '" class="col-md-4 col-form-label text-md-right title_name_label"> ' + data[indice].question + ' </label>' +
                        '<div class="col-md-6">' +
                        '<input id="' + data[indice].id + '" type="text" class="form-control" name="' + data[indice].question + '" value="" required autocomplete="' + data[indice].question + '" autofocus>' +
                        '</div>';
                }
            }


            if (html == "") {
                document.getElementById('form_register_client').innerHTML = '<div class="col-md-6 offset-md-4">No existen preguntas para este tipo de cliente.</div>';
            } else {
                html += '<div class="form-group row mb-0">' +
                    '<div class="col-md-6 offset-md-4">' +
                    '<button type="submit" class="btn btn-primary" id="saveClient">Guardar</button>' +
                    '</div>' +
                    '</div>';;
            }

            $('#form_register_client').append(html);



        }
    });
}


function edit_client(id) {

    $("#ClientEditModal" + id).modal("show");
    $('#formEditClients').attr('action', '/client/edit/' + id);

}

function delete_client(id) {

    $.ajax({
        url: '/client/delete/' + id,
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

                toastr.success('Se elimino el cliente correctamente.');

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