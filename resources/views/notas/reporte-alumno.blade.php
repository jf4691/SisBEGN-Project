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
<div class="row no-print">
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
                    <div class="float-right">
                      <a href="{{ URL::previous() }}" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                      <button type="button" class="btn btn-success" onclick="window.print()">
                        <i class="fa fa-print" style="margin-right: 3px;"></i> Imprimir
                      </button>
                    </div>
                    <p style="margin-top: 7px; color: #00a65a;"><i class="fa fa-check-circle" style="margin-right: 3px;"></i> Reporte de notas generado exitosamente</p>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>


<!-- Reporte -->
<section class="invoice" style="margin-left: 0; margin-right: 0">
  <!-- title row -->
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-2">
          <img src="{{ asset('img/sistema/logo3.png') }}" style="width: 145px; height:150px; margin: 15px" />
        </div>
        <div class="col-md-9" style="margin: 10px 15px 0px 15px">
          <h5 style="text-align:center"><b>COLEGIO PARTICULAR A DISTANCIA PCEI "BUENAS NUEVAS"</b></h5>
          <h6 style="text-align:center"><b>REPORTE DE NOTAS</b></h6><br>
          <b>Nombre Estudiante:</b> {{ Auth::user()->apellido }} {{ Auth::user()->nombre }}<br>
          <b>Grado:</b> {{ $grado->nivel->nombre }} <b>Paralelo:</b> "{{ $grado->seccion }}"<br>
          <b>Período:</b> {{ $grado->anio->numero }} <br>
          <b>Fecha:</b> {{ $hoy }}
        </div>
        <!-- /.col -->
      </div>

      <!-- Table row -->
        <div class="col-md-12 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                  <th>Nº</th>
                  <th>Materia</th>
                  <th>Parcial 1</th>
                  <th>Parcial 2</th>
                  <th>Promedio</th>
                  <th>Supletorio</th>
                  <th>Nota final</th>
                  <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($materias as $key => $item)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->notas['p1'] }}</td>
                <td>{{ $item->notas['p2'] }}</td>
                <td>{{ $item->notas['prom'] }}</td>
                <td>{{ $item->notas['sp'] }}</td>
                <td>{{ $item->notas['nf'] }}</td>
                <td>{{ $item->notas['estado'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      
      <!-- /.row -->
    </div>
  </div>

</section>
<!-- /.content -->
<div class="clearfix"></div>
@endsection