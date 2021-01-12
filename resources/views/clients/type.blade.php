
@extends('layouts.admin')

@section('content')
<div class="container">
  <button type="button" class="btn btn-info btn-round" data-toggle="modal" onclick="registrarTypeModal()">
    Registrar
  </button>  
</div>

<div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
        <div class="form-title text-center">
          <h4 id="title-modal">Tipo de cliente</h4>
        </div>

        <div class="d-flex flex-column text-center">
         
          <form method="POST" id="formRegisterType" action="" novalidate>
                        @csrf

                  
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                    


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
        </form>
         
          
          </div>
        </div>
    </div>
    
  </div>
</div>
<!-- modal -->


<div class="row justify-content-center">
      <div class="table-responsive" style="padding: 20px">
                      <div  class="row" id="proyectos" >
                            <div class="col-md-12">

                                <table class="table table-bordered table-striped table-hover toggle-circle default footable-loaded footable table table-striped table-class"  id= "type_clients">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody id="informacion">

                                    </tbody>
                                </table>
                            </div>
                      </div>
                      <br>
                      <br>

     
        </div>
</div>
<!-- MODAL PREGUNTAS -->
<div class="modal fade" id="QuestionModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-left: auto;margin-right: auto;">
    <div class="modal-dialog" role="document" style="margin-left: auto;margin-right: 28%;">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title-question" id="modal-title-question" style="text-aling:center;"></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="input-group col-md-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Preguntas:</label>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="col-12 col-md-6">

                        <select class="custom-select" id="question_select" name="question_select" >
                      
                        </select>

                        <input type="text" name="Agregarpreguntas" style="display: none;"
                            id="Agregarpreguntas" class="form-control">
                        <input type="text" name="Editarpreguntas" style="display: none;"
                            id="Editarpreguntas" class="form-control">

                    </div>
                



              
                    <div class="col-12 col-md-4">
                        <button id="btnRegisterQuestion" class="btn btn-info btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-plus"></i>
                        </button>

                        <button id="btnEditQuestion" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                        <i class="far fa-edit"></i>
                        </button>

                        <button id="btnSaveQuestion" style="display: none;" class="btn btn-info  btn-fab btn-fab-mini btn-round">
                        <i class="far fa-save"></i>
                        </button>

                        <button id="btnEditSaveQuestion" style="display: none;" class="btn btn-info btn-fab btn-fab-mini btn-round">
                        <i class="far fa-save"></i>
                        </button>

                        <button id="btnDeleteQuestion" type="button"  class="btn btn-danger btn-fab btn-fab-mini btn-round">
                          <i class="fas fa-trash"></i>
                        </button>

                        <button id="btnCloseQuestion" style="display: none;" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-times"></i>
                        </button>

                       
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>
<!-- FIN -->


@endsection

@section('js')
<script src="{{ asset('js/funciones_type_client.js') }}"></script>
@endsection