@extends('layouts.general')

@section('titulo', 'SISBEGN | Notas')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('encabezado', 'Notas')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-star"></i> Notas
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <!-- Barra de búsqueda -->
    @include('notas.search-anio')
  </div>
</div><br>

<div class="row">
  <div class="col-md-6">
    <!-- Lista de grados donde se es orientador -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Reporte de Notas</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="card-body my-card-body">
        @if (count($grados) > 0)
        <ul class="products-list">
          @foreach ($grados as $grado)
          <li class="item my-style-item">
            <div class="product-img">
              <i class="fas fa-graduation-cap fa-3x color-graduation-cap"></i>
            </div>
            <div class="product-info">
              @if (Auth::user()->estud())
              <a href="{{ route('notas.alumno', $grado->id) }}" class="product-title my-product-title">{{ $grado->codigo }}</a>
              @else
              <a href="{{ route('notas.create-reporte', $grado->id) }}" class="product-title my-product-title">{{ $grado->codigo }}</a>
              @endif
              <span class="product-description">{{ $grado->nivel->nombre }} "{{ $grado->seccion }}"</span>
            </div>
          </li>
          <!-- /.item -->
          @endforeach
        </ul>
        @endif
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>

  @if (count($materias) > 0)
  <div class="col-md-6">
    <!-- Lista de grados -->
    @foreach ($grados_ids as $item)
      @foreach ($materias as $row)
        @if ($item == $row->grado_id)

          <div class="card card-primary collapsed-card">
            <div class="card-header color-template">
              <h3 class="card-title"  style="color: #ffffff"><strong class="my-textcolor-breadcrumb">Grado:</strong> {{ $row->grado }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="card-body my-card-body">
              <!-- Lista de materias -->
              <ul class="">
                @foreach ($materias as $materia)
                  @if ($item == $materia->grado_id)
                    <li><a href="{{ route('notas.edit', $materia->gra_mat) }}" class="product-title"><b>{{$materia->nombre}}</b></a></li>
                  @endif
                @endforeach
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          @php
              break;
          @endphp
        @endif
      @endforeach
    @endforeach

  </div>
  @endif
</div>
@endsection

@section('scripts')
<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
@endsection