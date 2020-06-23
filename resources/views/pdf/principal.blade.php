@extends('layouts.general')

@section('titulo', 'SISBEGN | Reportes')

@section('encabezado', 'Reportes')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Administración
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('reportes') }}">Reportes</a>
</li>
<li class="breadcrumb-item active">
  Descargar Reportes
</li>
@endsection

@section('contenido')

<div class="card card-primary">
  <div class="card-header color-template">
    <h3 class="card-title"  style="color: #ffffff">Reportes</h3>
  </div>
 
 <form class="form-horizontal">
 <div class="container" id="reporte">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Reporte de Grados</h2>
          <p>Lista de los grados de la institución</p>
          <p><a class="btn my-btn-style-success" href="{{ route('grados.pdf') }}" role="button">Ver &raquo;</a></p>
        </div>
       
        <div class="col-md-4">
          <h2>Reporte de Docentes</h2>
          <p>Lista de todos los Docentes de la institución</p>
          <p><a class="btn my-btn-style-success" href="{{ route('docentes.pdf') }}" role="button">Ver &raquo;</a></p>
        </div>
       
        <div class="col-md-4">
          <h2>Reporte de Materias</h2>
          <p>Lista de todas las materias de la institución</p>
          <p><a class="btn my-btn-style-success" href="{{ route('materias.pdf') }}" role="button">Ver &raquo;</a></p>
        </div>

        <div class="col-md-4">
          <h2>Reporte de Niveles</h2>
          <p>Lista de todas los Niveles de la institución</p>
          <p><a class="btn my-btn-style-success" href="{{ route('nivel.pdf') }}" role="button">Ver &raquo;</a></p>
        </div>

      </div>
    </div> <!-- /container -->    
</div>
</form>

@endsection