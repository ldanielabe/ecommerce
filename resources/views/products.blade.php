
@extends('layouts.admin')

@section('content')
<div class="container">
  <button type="button" class="btn btn-info btn-round" data-toggle="modal" onclick="registrarProductModal()">
    Registrar
  </button>  
</div>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
         
        <form method="POST" id="formRegisterProduct" action="" novalidate>
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

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">{{ __('Celular') }}</label>

                            <div class="col-md-6">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}" required autocomplete="stock" autofocus>

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

                                <table class="table table-bordered table-striped table-hover toggle-circle default footable-loaded footable table table-striped table-class"  id= "product_table">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
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



@endsection

@section('js')
<script src="{{ asset('js/funciones_product.js') }}"></script>
@endsection