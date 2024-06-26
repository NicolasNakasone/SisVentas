@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <h3>Editar Articulo: {{$articulo->nombre}}</h3>
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
  {!!Form::model($articulo,['method'=>'PATCH','route'=>['almacen.articulo.update',$articulo->idarticulo],'files'=>'true'])!!}
  {!!Form::token()!!}
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" class="form-control" required value="{{$articulo->nombre}}" placeholder="Ingrese el nuevo nombre del articulo">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="nombre">Codigo</label>
        <input type="text" name="codigo" class="form-control" required value="{{$articulo->codigo}}" placeholder="Ingrese el nuevo codigo del articulo">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label>Categoria</label>
        <select name="idcategoria" class="form-control">
          @foreach ($categorias as $cat)
            @if($cat->idcategoria==$articulo->idcategoria)
              <option value="{{$cat->idcategoria}}" selected>{{$cat->nombre}}</option>
            @else
              <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" name="stock" class="form-control" required value="{{$articulo->stock}}" placeholder="Ingrese el nuevo stock del articulo">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" class="form-control">
        @if(($articulo->imagen)!="")
          <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" height="200px">
        @endif
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <input type="text" name="descripcion" class="form-control" value="{{$articulo->descripcion}}" placeholder="Ingrese una nueva descripcion del articulo">
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