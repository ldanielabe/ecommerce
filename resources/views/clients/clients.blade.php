@extends('layouts.admin')

@section('content')
<div class="container" id="container">
    <button type="button" class="btn btn-info btn-round"  id="registrarClient">
        Registrar
    </button>
</div>

<div class="modal fade" id="ClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <div class="form-title text-center">
                    <h4 id="title-modal"></h4>
                </div>

                <div class="d-flex flex-column text-center">

                    <form method="POST" id="formRegisterClients" action="" novalidate>
                        @csrf

                        <select class="custom-select" id="client_select" name="client_select" >
                        @for ($i = 0; $i < sizeof($type_clients); $i++)
                        <option value="{{$type_clients[$i]->id}}">{{$type_clients[$i]->name}}</option>
                        @endfor
                        </select>


                        <div class="form-group row" id="form_register_client">
                       
                        </div>


                        
                    </form>


                </div>
            </div>



        </div>

    </div>
</div>
<!-- modal -->

@for ($i = 0; $i < $number_client; $i++)
<div class="modal fade" id="ClientEditModal{{$i+1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <div class="form-title text-center">
                    <h4 id="title-modal">Editar cliente</h4>
                </div>

                <div class="d-flex flex-column text-center">

                    <form method="GET" id="formEditClients" action="" novalidate>
                        @csrf
                        <input type="hidden" id="btnClickedValue" name="btnClickedValue" value="-1" />
                      
                        <div class="form-group row" id="form_edit_client">

                        @for ($j = 0; $j < sizeof($client); $j++)
                        @if($client[$j]->id_client==($i+1))
                      
                        <label for="{{$client[$j]->question}}" class="col-md-4 col-form-label text-md-right title_name_label"> {{$client[$j]->question}} </label>
                        <div class="col-md-6">
                        <input id="{{$client[$j]->id}}" type="text" class="form-control" name="{{$client[$j]->answer}}" value="{{$client[$j]->answer}}" required autofocus>
                        </div>

                        @endif
                        @endfor    

                        </div>

                        <button id="btnEditSaveClients" type="submit" class="btn btn-info btn-sm">
                            <i class="far fa-save"></i> 
                        </button>
                        
                    </form>


                </div>
            </div>



        </div>

    </div>
</div>
@endfor
<!-- modal -->

<div class="grid-container">
@for ($i = 0; $i < $number_client; $i++)
<div class="card">
    <img src="https://www.wortis.fr/wp-content/uploads/2018/06/client.png" class="card-img-top"  style="width: rem;" alt="...">
    <div class="card-body">
        <h5 class="card-title" id="title_clients"></h5>
    </div>

    @for ($j = 0; $j < sizeof($client); $j++)
    @if($client[$j]->id_client==($i+1))
    <ul class="list-group list-group-flush" id="data_clients">
        <li class="list-group-item" style="display: flex;"><h3>{{$client[$j]->question}}:</h3> <p style="padding-left: 0.5rem;">{{$client[$j]->answer}}</p></li>
    </ul>
    
    @endif
    @endfor
    <div class="card-body">
        <button id="btnEditSaveClients" class="btn btn-info btn-sm" onclick="edit_client({{$i+1}})">
            <i class="far fa-edit"></i> 
        </button>

        <button id="btnDeleteClients" type="button" class="btn btn-danger btn-sm" onclick="delete_client({{$i+1}})"> 
            <i class="fas fa-trash"></i>
        </button>
    </div>
</div>

@endfor
</div>
<!-- table -->

@endsection

@section('js')
<script src="{{ asset('js/funciones_client.js') }}"></script>
@endsection