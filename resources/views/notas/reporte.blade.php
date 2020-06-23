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
<style>
  
</style>
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
                        <strong class="my-textcolor-breadcrumb">Grado:</strong> {{ $grado->codigo }}&nbsp;&nbsp;
                      </li>
                      {{-- Mostrar el tipo de reporte --}}
                      <li>
                        @php
                            switch($tipo) {
                              case 'P1':
                                echo 'Parcial 1';
                                break;
                              case 'P2':
                                echo 'Parcial 2';
                                break;
                              case 'all':
                                echo 'Reporte Extendido';
                                break;
                              default:
                                echo 'Nota Final';
                                break;
                            }
                        @endphp
                      </li>
                    </ol>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12">
                    <div class="float-right">
                      <a href="{{ route('notas.create-reporte', $grado->id) }}" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
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


<section class="invoice" style="margin-left: 0; margin-right: 0">
  <!-- title row -->
  
  <div class="row">
    <div class="col-md-12">
      
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="tdNombre">

            
        
          <div class="row">
            <div class="col-md-2">
              <img src="{{ asset('img/sistema/logo3.png') }}" style="width: 145px; height:150px; margin: 15px" />
            </div>
            <div class="col-md-9" style="margin: 10px 15px 0px 15px">
              <h5 style="text-align:center">COLEGIO PARTICULAR A DISTANCIA PCEI "BUENAS NUEVAS"</h5>
              <h6 style="text-align:center">REPORTE DE NOTAS @php switch($tipo) {
                                                                                  case 'P1':
                                                                                    echo 'PARCIAL 1';
                                                                                    break;
                                                                                  case 'P2':
                                                                                    echo 'PARCIAL 2';
                                                                                    break;
                                                                                  case 'all':
                                                                                    echo 'EXTENDIDO';
                                                                                    break;
                                                                                  default:
                                                                                    echo 'FINALES';
                                                                                    break;
                                                                                }
                                                                            @endphp</h6><br>
              <b>Grado:</b> {{ $grado->nivel->nombre }}, <b>Paralelo:</b> "{{ $grado->seccion }}"<br>
              <b>Período:</b> {{ $grado->anio->numero }} <br>
              <b>Fecha:</b> {{ $hoy }}
              <b></b>
            </div>
          </div>
        
      
    

  
  <!-- Table row -->
  @if ($tipo != 'all')
  
    <div class="col-md-12 table-responsive">
      <table class="table table-bordered">
        <thead>
        <tr>
          <th rowspan="2" style="width: 12px">No.</th>
          <th rowspan="2">Nombre de los estudiantes</th>
          <th colspan="{{ count($materias) }}" style="text-align: center;">Asignatura</th>
        </tr>
        <tr>
          @foreach ($materias as $materia)
          <th style="width: 50px;"><span class="tabla-letra-vertical">{{ $materia->nombre }}</span></th>
          @endforeach
        </tr>
        </thead>
        <tbody>
          
          @for ($i = 0; $i < count($matriculas_reales); $i++)
          <tr>
            <td>{{ $i + 1 }}.</td>
            <td class="tdNombre">{{ $matriculas_reales[$i]->alumno->apellido }}, {{ $matriculas_reales[$i]->alumno->nombre }}</td>
            @for ($j = 0; $j < count($materias); $j++)
            <td>{{ $notas[$j][$i] }}</td>
            @endfor
          </tr>
          @endfor
       
        </tbody>
        @if (!Auth::user()->estud())
        <tfoot>
          <tr>
            <th></th>
            <th style="text-align:right">Promedio</th>
            @foreach ($promedios as $promedio)
            <th>{{ $promedio }}</th>
            @endforeach
          </tr>
        </tfoot>
        @endif
      </table>
    </div>
    <!-- /.col -->
  
  @endif
  <!-- /.row -->

  {{-- Reporte para mostrar todas las notas de todos los alumnos --}}
  @if ($tipo == 'all')
  
    <div class="col-md-12 table-responsive">
      
      @foreach ($materias as $materia)

      <table class="table table-bordered table-striped table-condensed">
        <tr><th colspan="2" class="tdNombre info">{{ $materia->nombre }}</th></tr>
        <tr>
          <th>N°</th>
          <th>Estudiantes</th>
          <th>Parcial 1</th>
          <th>Parcial 2</th>
          <th>Promedio</th>
          <th>Supletorio</th>
          <th>Nota final</th>
          <th>Estado</th>
        </tr>
        @for ($i = 0; $i < count($matriculas_reales); $i++)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td class="tdNombre">
            {{ $matriculas_reales[$i]->alumno->apellido }}, {{ $matriculas_reales[$i]->alumno->nombre }}
          </td>
          <td>
            {{ $tmp_notas[$matriculas_reales[$i]->alumno->id][$materia->id]['p1'] }}
          </td>
          <td>
            {{ $tmp_notas[$matriculas_reales[$i]->alumno->id][$materia->id]['p2'] }}
          </td>
          <td>
            {{ $tmp_notas[$matriculas_reales[$i]->alumno->id][$materia->id]['prom'] }}
          </td>
          <td>
            {{ $tmp_notas[$matriculas_reales[$i]->alumno->id][$materia->id]['sp'] }}
          </td>
          <td>
            {{ $tmp_notas[$matriculas_reales[$i]->alumno->id][$materia->id]['nf'] }}
          </td>
          <td>
            {{ $tmp_notas[$matriculas_reales[$i]->alumno->id][$materia->id]['estado'] }}
          </td>
        </tr>
        @endfor

      </table>

      @endforeach
      
    </div>
    <!-- /.col -->
  
  @endif

  @if ($tipo == 'Nf')
  <!-- Table row -->
  
    <div class="col-md-12 table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th colspan="6" style="text-align: center;">Estadísticas</th>
          </tr>
          <tr>
            <th>Género</th>
            <th>Matrícula inicial</th>
            <th>Retirados</th>
            <th>Matrícula final</th>
            <th>Promovidos</th>
            <th>Reprobados</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Femenino</th>
            <td>{{ $estadisticas['matricula_inicial_femenina'] }}</td>
            <td>{{ $estadisticas['retiradas'] }}</td>
            <td>{{ $estadisticas['matricula_final_femenina'] }}</td>
            <td>{{ $estadisticas['promovidas'] }}</td>
            <td>{{ $estadisticas['retenidas'] }}</td>
          </tr>
          <tr>
            <th>Masculino</th>
            <td>{{ $estadisticas['matricula_inicial_masculina'] }}</td>
            <td>{{ $estadisticas['retirados'] }}</td>
            <td>{{ $estadisticas['matricula_final_masculina'] }}</td>
            <td>{{ $estadisticas['promovidos'] }}</td>
            <td>{{ $estadisticas['retenidos'] }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Total</th>
            <td>{{ $estadisticas['matricula_inicial_femenina'] + $estadisticas['matricula_inicial_masculina'] }}</td>
            <td>{{ $estadisticas['retiradas'] + $estadisticas['retirados'] }}</td>
            <td>{{ $estadisticas['matricula_final_femenina'] + $estadisticas['matricula_final_masculina'] }}</td>
            <td>{{ $estadisticas['promovidas'] + $estadisticas['promovidos'] }}</td>
            <td>{{ $estadisticas['retenidas'] + $estadisticas['retenidos'] }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.col -->
  
  <!-- /.row -->
  @endif
</td>
</tr>
  </tbody>
  </table>
</div>
  <!-- /.col -->
</div>
</section>
<!-- /.content -->

@endsection