@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <h3>Editar Proveedor: {{$persona->nombre}}</h3>
      @if(count($errors)>0)
      <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
        </ul>
      </div>
      @endif
    </div>
  </div>
  {!!Form::model($persona,['method'=>'PATCH','route'=>['compras.proveedor.update',$persona->idpersona]])!!}
  {!!Form::token()!!}
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control" placeholder="Ingrese el nuevo nombre del proveedor">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label>Tipo de Documento</label>
        <select name="tipo_documento" class="form-control">
          <option value="DNI">DNI</option>
          <option value="PASS">PASSPORT</option>
        </select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="num_documento">Numero de Documento</label>
        <input type="number" name="num_documento" required value="{{$persona->num_documento}}" class="form-control" placeholder="Ingrese el nuevo numero de documento del proveedor">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Ingrese la nueva direccion del proveedor">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="Ingrese el nuevo numero de telefono del proveedor">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="email" value="{{$persona->email}}" class="form-control" placeholder="Ingrese el nuevo email del proveedor">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <button class="btn btn-danger" type="reset">Cancelar</button>
      </div>
    </div>
  </div>
  {!!Form::close()!!}
@endsection