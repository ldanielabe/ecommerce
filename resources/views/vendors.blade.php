
@extends('layouts.admin')

@section('content')
<div class="container">
  <button type="button" class="btn btn-info btn-round" data-toggle="modal" onclick="registrarVendorModal()">
    Registrar
  </button>  
</div>

<div class="modal fade" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
         
          <form method="POST" id="formRegisterVendor" action="" novalidate>
                        @csrf

                        <div class="form-group row">
                            <label for="identification" class="col-md-4 col-form-label text-md-right">{{ __('Identificación') }}</label>

                            <div class="col-md-6">
                                <input id="identification" type="number" class="form-control @error('identification') is-invalid @enderror" name="identification" value="{{ old('identification') }}" required autocomplete="identification" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

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

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Celular') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> 

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-group">
                            <label for="password" id="txt-password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-confirm-group">
                            <label for="password_confirm" id="txt-password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirm" type="password" class="form-control" name="password_confirm" required autocomplete="new-password" autofocus>
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

                                <table class="table table-bordered table-striped table-hover toggle-circle default footable-loaded footable table table-striped table-class"  id= "vendor_table">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
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
<!-- table -->

<!-- MODAL ASIGNAR CLIENTES -->
<div class="modal fade" id="AssignModal" tabindex="-1" role="dialog"
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
                            <label class="input-group-text" for="inputGroupSelect01">Clientes:</label>
                        </div>
                    </div>
                    <hr>
                    
                 

                    <select id="client_select" name="client_select" class="selectpicker" multiple >
                   

                    </select>


                   
                

              
                    <div class="col-12 col-md-4">
                        <button id="btnRegisterAssign" class="btn btn-info btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-save"></i>
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
<script src="{{ asset('js/funciones.js') }}"></script>
@endsection