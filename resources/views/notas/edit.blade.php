@extends('layouts.general')

@section('titulo', 'SISBEGN | Notas')

@section('encabezado', 'Notas')

@section('subencabezado', $grado->codigo . ' - ' . $materia->nombre)

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-star"></i>
  <a href="{{ route('notas.index') }}">Notas</a>
</li>
<li class="breadcrumb-item active">{{ $grado->codigo }} - {{ $materia->nombre }}</li>
@endsection

@section('contenido')
<style>
  .hnombres{
    width: 25vw;
    text-align: center;
  }
  .htable{
    width: 8vw;
    text-align: center;
  }
  td{
    width: 2vw;
  }
  
</style>
<div class="row">
  <div class="col-md-12">
    <!-- Box Primary -->
    <div class="card card-success">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registro de Notas</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          <div class="col-md-12">
            <ol class="breadcrumb color-template my-breadcrumb">
              <li>
                <strong class="my-textcolor-breadcrumb">Año:</strong> {{ $grado->anio->numero }}&nbsp;&nbsp;
              </li>
              <li>
                <strong class="my-textcolor-breadcrumb">Grado:</strong> {{ $grado->codigo }}&nbsp;&nbsp;
              </li>
              <li>
                <strong class="my-textcolor-breadcrumb">Materia:</strong> {{ $materia->nombre }}
              </li>
            </ol>
          </div>
        </div>
        <div class="row search-margen">
          <div class="col-md-12">
            @include('notas.search-alumno')
          </div>
        </div>
        <!-- Listado de notas -->

        @if (true)
        
        <!-- Formulario -->
        {!! Form::open(['route' => ['notas.update'], 'autocomplete' => 'off', 'method' => 'PUT']) !!}
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th class="hnombres">APELLIDOS Y NOMBRES</th>
                <th class="htable">PARCIAL 1</th>
                <th class="htable">PARCIAL 2</th>
                <th class="htable">PROMEDIO</th>
                <th class="htable">SUPLETORIO</th>
                <th class="htable">NOTA FINAL</th>
                <th class="htable">ESTADO</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($matriculas as $matricula)
              <tr>
                <td class="tdNombre">{{ $matricula->alumno->apellido }} {{ $matricula->alumno->nombre }}</td>
                <td class="text-right">
                  @if ($grado->registros == 'parcial_1')
                    {!! Form::number('parcial_1[]['.$matricula->alumno_id.']', $matricula->notas->parcial_1, ['class' => 'form-control', 'min' => 00.00,'max' => 10.00, 'step' => 0.01, 'required']) !!}
                  @else
                    <span>{{ $matricula->notas->parcial_1 }}</span>
                    {!! Form::hidden('parcial_1[]['.$matricula->alumno_id.']', $matricula->notas->parcial_1, ['class' => 'form-control']) !!}
                  @endif
                </td>

                <td class="text-right">
                  @if ($grado->registros == 'parcial_2')
                    {!! Form::number('parcial_2[]['.$matricula->alumno_id.']', $matricula->notas->parcial_2, ['class' => 'form-control','min' => 00.00,'max' => 10.00, 'step' => 0.01, 'required']) !!}
                  @else
                    <span>{{ $matricula->notas->parcial_2 }}</span>
                    {!! Form::hidden('parcial_2[]['.$matricula->alumno_id.']', $matricula->notas->parcial_2, ['class' => 'form-control']) !!}
                  @endif
                </td>
                
                <td class="text-right">
                  <span> {{ $matricula->notas->promedio }} </span>
                </td>
                <td class="text-right">
                  @php
                    $ifRead = 'readonly';
                    if ($matricula->notas->promedio >= 4 && $matricula->notas->promedio < 7 && $grado->registros == 'supletorio') {
                      $ifRead = '';
                    }
                  @endphp
                  @if ($ifRead != 'readonly')
                    {!! Form::number('supletorio[]['.$matricula->alumno_id.']', $matricula->notas->supletorio, ['class' => 'form-control', 'min' => 00.00,'max' => 10.00, 'step' => 0.01, 'required']) !!}
                  @else
                    <span>{{ $matricula->notas->supletorio }}</span>
                    {!! Form::hidden('supletorio[]['.$matricula->alumno_id.']', $matricula->notas->supletorio, ['class' => 'form-control']) !!}
                  @endif
                </td>
                <td class="text-right">
                  <span>{{ $matricula->notas->nota }}</span>
                  {!! Form::hidden('nota_final[]['.$matricula->alumno_id.']', $matricula->notas->nota, ['required']) !!}
                </td>
                <td>
                  @switch($matricula->notas->estado)
                    @case ('Aprobado')
                      <center><p class="badge badge-success">APROBADO</p></center>
                      @break
                    @case ('Suspenso')
                      <center><span class="badge badge-warning">SUSPENSO</span></center>
                      @break
                    @case ('Reprobado')
                      <center><span class="badge badge-danger">REPROBADO</span></center>
                      @break
                    @default
                      <center><span class="badge badge-info"><i class="fa fa-spinner fa-spin"></i></span></center>
                      @break
                  @endswitch
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div  class="float-right">
              <a href="{{ route('notas.index') }}" class="btn btn-secondary">Cancelar</a>
              <button type="submit" class="btn btn-success" {{ ($grado->registros == 'ninguno') ? 'disabled' : '' }}>Actualizar</button>
            </div>
          </div>
        </div>
        {!! Form::hidden('gra_mat', $gra_mat, ['required']) !!}
        {!! Form::close() !!}
        <!-- Si no hay evaluaciones -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron evaluaciones</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection

@section('scripts')
@endsection