@extends('layouts.general')

@section('titulo', 'SISBEGN | Reporte de Docentes')

@section('encabezado')
<button type="button" class="btn btn-primary" style="margin-right: 5px;" onclick="window.print()">
            <i class="fa fa-download"></i> Generar PDF
          </button>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 align="center">
          Colegio Particular a Distancia Buenas Nuevas <br>
          Desde 1990 <br>
          Quito, Ecuador <br>
        </h3>
        <center>
          <img src="{{ asset('img/sistema/logo3.png') }}" style="width: 190px; height: 190px;" >
        </center>
        <h4 align="center">REPORTE DE GRADOS</h4>
      </div>
      <div class="card-body my-card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Nivel</th>
                  <th>Año</th>
                  <th>Docente</th>
                  <th>Seccion</th>
                </tr>
              </thead>
              <tbody>
                @foreach($grados as $grado)
                  <tr>
                    <td>{{ $grado->codigo }}</td>
                    <td>{{ $grado->nivel->nombre }}</td>
                    <td>{{ $grado->anio->numero }}</td>
                    <td>{{ $grado->docente->user->nombre }}
                        {{ $grado->docente->user->apellido }}</td>
                    <td>{{ $grado->seccion }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection





