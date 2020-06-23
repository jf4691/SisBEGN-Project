@extends('layouts.general')

@section('titulo', 'SISBEGN | Crear Período Académico')

@section('encabezado', 'Período Académico')

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Configuración
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('anios.index') }}">Período Académico</a>
</li>
<li class="breadcrumb-item active">
  Registrar Período Académico
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Período Académico</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'anios.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">

          <!-- Número -->
          <div class="form-group row{{ $errors->has('numero') ? ' has-error' : '' }}">
            {!! Form::label('numero', 'Período Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <input type="text" name="numero" value="{{old('numero')}}" class="form-control" placeholder="Ej: 2000-X" maxlength="6" required>
              {{-- {!! Form::number('numero', old('numero'), ['class' => 'form-control', 'placeholder' => 'Año Escolar', 'required']) !!} --}}
              @if ($errors->has('numero'))
                <span class="text-danger">{{ $errors->first('numero') }}</span>
              @endif
            </div>
          </div>

          <!-- Activo -->
          


          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Activo</label>
            <div class="col-sm-5 check-group custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="activo" id="activo" value="1"> 
              <label class="custom-control-label text-checkbox" for="activo"> Indica si este es el período activo. 
              Permite visualizar primero los registros pertenecientes a este período. Solo puede 
              existir un período académico activo.</label>
            </div>
          </div>
          <!-- Editable -->
          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Editable</label>
            <div class="col-sm-5 check-group custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="editable" id="editable" value="1"> 
              <label class="custom-control-label text-checkbox" for="editable"> Al activar esta casilla permite que registros pertenecientes a este año lectivo 
              puedan ser editados. En caso de no marcar, los registros pertenecientes a este año 
              no podrán visualizarse en el sistema.</label>
            </div>
          </div>

        </div>

        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('anios.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection