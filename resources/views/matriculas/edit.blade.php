@extends('layouts.general')

@section('titulo', 'SISBEGN | Matrículas')

@section('encabezado', 'Matrículas')

@section('subencabezado', '')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-child"></i>
  <a href="{{ route('matriculas.index') }}">Matrículas</a>
</li>
<li class="breadcrumb-item active">
  Registrar Matrícula
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Editar Matrícula</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => ['matriculas.update', $matricula], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Alumno -->
          <div class="form-group row">
            {!! Form::label('alumno_id', 'Estudiante', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {{-- {{Auth::user()->find($matricula->alumno->user_id)->nombre}} --}}
              {!! Form::text('alumno_id', Auth::user()->find($matricula->alumno->user_id)->nombre . ' ' . Auth::user()->find($matricula->alumno->user_id)->apellido, ['class' => 'form-control', 'disabled']) !!}
            </div>
          </div>
          <!-- Grado -->
          <div class="form-group row">
            {!! Form::label('grado_id', 'Grado', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="grado_id" class="form-control select2" id="grado_id" aria-placeholder="--Seleccione un grado--" required>
                <option value="">-- Seleccione un grado --</option>
                @foreach($grados as $gra)
                  @if($gra->id == $matricula->grado_id)
                    <option value="{{$gra->id}}" selected>{{$gra->codigo}}</option>
                  @else
                    <option value="{{$gra->id}}">{{$gra->codigo}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <!-- Fecha de matriculación -->
          <div class="form-group row">
            {!! Form::label('created_at', 'Fecha de matriculación', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('created_at', \Carbon\Carbon::parse($matricula->created_at)->format('d/m/Y'), ['class' => 'form-control', 'disabled']) !!}
            </div>
          </div>
          <!-- Deserción -->
          
          @if($notas != false)
          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Estudiante retirado</label>
            <div class="checkbox">
              <div class="col-sm-5 check-group">
                {!! Form::checkbox('desercion', 1, $desercion) !!}
              </div>
            </div>
          </div>
          @endif




          
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
          </div>
        </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection