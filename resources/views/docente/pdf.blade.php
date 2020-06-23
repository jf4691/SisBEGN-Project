@extends('layouts.general')

@section('titulo', 'SISBEGN | Reporte de Docentes')

@section('encabezado')
<button type="button" class="btn btn-primary" style="margin-right: 5px;" onclick="window.print()">
            <i class="fa fa-download"></i> Generar PDF
          </button>
@endsection

@section('contenido')
<div class="card card-primary">
  <div class="card-header">
<h3 align="center">
Colegio Particular a Distancia Buenas Nuevas <br>
Desde 1990 <br>
Quito, Ecuador <br>
</h3>
<center>
<img src="{{ asset('img/sistema/logo3.png') }}" style="width: 190px; height: 190px;" >
</center>
<h4 align="center">REPORTE DE DOCENTES</h4>

<div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Especialidad</th>
          </tr>
        </thead>
        <tbody>
          @foreach($docentes as $docente)
          <tr>
            <td>{{ $docente->cedula }}</td>
            <td>{{ $docente->nombre }}
                 {{$docente->apellido}} </td>
            <td>{{ $docente->especialidad }}</td>
            </tr>
 @endforeach

    </tbody>
          </table>

</div>
</div>
</div>

@endsection