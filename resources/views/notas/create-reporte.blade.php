{{-- Blade principal para reporte de NOTAS --}}
@extends('layouts.general')

@section('titulo', 'SISBEGN | Reporte de Notas')

@section('encabezado', $grado->codigo)

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-star"></i>
  <a href="{{ route('notas.index') }}">Notas</a>
</li>
<li class="breadcrumb-item active">Reporte de Notas</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <div class="card card-tabs">
      <div class="card-header color-template p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Reporte de Notas</a>
          </li>
        </ul>
      </div>
      <div class="card-body my-card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
          <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
              <div class="row">
                  <div class="col-md-12">
                    <ol class="breadcrumb color-template my-breadcrumb">
                      <li>
                        <strong class="my-textcolor-breadcrumb">Año:</strong> {{ $grado->anio->numero }}&nbsp;&nbsp;
                      </li>
                      <li>
                        <strong class="my-textcolor-breadcrumb">Grado:</strong> {{ $grado->codigo }}
                      </li>
                    </ol>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12">
                    <!-- Formulario -->
                    {!! Form::open(['route' => 'notas.reporte', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                      <!-- Grado -->
                      <div class="form-group row">
                        {!! Form::label('grado_id', 'Grado *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
                        <div class="col-sm-5">
                          {!! Form::text('grado', $grado->codigo, ['class' => 'form-control', 'disabled']) !!}
                          {!! Form::hidden('grado_id', $grado->id, ['required']) !!}
                        </div>
                      </div>
                      <!-- Tipo de reporte -->
                      <div class="form-group row{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        {!! Form::label('tipo', 'Tipo de reporte *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
                        <div class="col-sm-5">
                          {!! Form::select('tipo', ['P1' => 'Parcial 1', 'P2' => 'Parcial 2', 'Nf' => 'Nota final', 'all' => 'Reporte extendido'], old('tipo'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un tipo de reporte --', 'onchange' => 'desbloquear(this.value);', 'required'] ) !!}
                          <span class="" style="text-align:justify; font-size:10pt"><small>El reporte de NOTA FINAL incluye cuadro de estadísticas en el que se muestra número de matrículas, número de estudiantes retirados, promovidos y reprobados en el período activo.</small></span>
                          @if ($errors->has('tipo'))
                          <span class="text-danger">{{ $errors->first('tipo') }}</span>
                          @endif
                        </div>
                      </div>
      
                      <form>
                        <div class="float-right">
                          <button type="submit" class="btn btn-success"">Generar reporte</button>
                        </div>
                      </form>
                    {!! Form::close() !!}
                  </div>
              </div>
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
// Funcion que se ejecuta al seleccionar una opcion del select.

</script>
@endsection