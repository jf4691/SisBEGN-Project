@extends('layouts.general')

@section('titulo', 'SISBEGN | Matrículas')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('encabezado', 'Matrículas')

@section('subencabezado', 'Registro')

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
        <h3 class="card-title"  style="color: #ffffff">Registrar Matrícula</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'matriculas.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Anio -->
          <div class="form-group row{{ $errors->has('anio_id') ? ' has-error' : '' }}">
            {!! Form::label('numero>', 'Período Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="anio_id" id="anio_id" class="form-control" required>
                @foreach ($anios as $anio)
                  <option value="{{$anio->id}}">{{$anio->numero}}</option>
                @endforeach
              </select>
              @if ($errors->has('anio_id'))
              <span class="text-danger">{{ $errors->first('anio_id') }}</span>
              @endif
            </div>
          </div>

          <!-- Alumno -->
          <div class="form-group row{{ $errors->has('alumno_id') ? ' has-error' : '' }}">
            {!! Form::label('alumno_id', 'Estudiante *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="alumno_id" class="form-control select2" id="alumno_id" aria-placeholder="--Seleccione un Alumno--" required>
                <option value="">-- Seleccione un Estudiante --</option>
                @foreach($alumnos as $alu)
                  <option value="{{ $alu->id }}">{{$alu->cedula}} - {{$alu->apellido}} {{$alu->nombre}}</option>
                @endforeach
              </select>
              @if ($errors->has('alumno_id'))
              <span class="text-danger">{{ $errors->first('alumno_id') }}</span>
              @endif
              <p class="" id="msg_alumno">
                
              </p>
            </div>
          </div>
          <!-- Grado -->
          <div class="form-group row{{ $errors->has('grado_id') ? ' has-error' : '' }}">
            {!! Form::label('grado_id', 'Grado *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="grado_id" class="form-control select2" id="grado_id" aria-placeholder="--Seleccione un grado--" required>
                <option value="">-- Seleccione un grado --</option>
                @foreach($grados as $gra)
                  <option value="{{$gra->id}}">{{$gra->codigo}}</option>
                @endforeach
              </select>
              @if ($errors->has('grado_id'))
              <span class="text-danger">{{ $errors->first('grado_id') }}</span>
              @endif
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
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

@section('scripts')
<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

    $('#alumno_id').change(function(){
      var alu_id = $(this).children('option:selected').val();
      $('#msg_alumno').empty();
      $.ajax({
        type : 'GET',
        url : '{{ url("/api/getgrado") }}',
        data:{'alumno_id':alu_id},
        success:function(data){
            // console.log(data);
            // Si el estudiante es nuevo
            if (data['ifestado'] == true) {
              $('#msg_alumno').append('<span class="text-success"><i class="fa fa-check-circle" style="margin-right: 3px;"></i> Estudiante nuevo</span>');
              // Si el alumno es nuevo y tiene alguna materia aprobada
              if (data['grado_aprob'] != null) {
                $('#msg_alumno').append('</br><span class="text-success"><i class="fa fa-check-circle" style="margin-right: 3px;"></i> Último Grado Aprobado: <strong>'+data['grado_aprob']+'</strong></span>');
              }
            }else if (data['ifestado'] == false) {
              // El alumno es un alumno antiguo
              $('#msg_alumno').append('<span class="text-primary"><i class="fa fa-check-circle" style="margin-right: 3px;"></i> Estudiante regular</span>');
              if (data['estado_alumno'] == 'aprobado') {
                // Si el alumno aprobo el grado
                $('#msg_alumno').append('</br><span class="text-success"><i class="fa fa-check-circle" style="margin-right: 3px;"></i> El estudiante aprobó <strong>'+data['grado']+'</strong> exitosamente</span>');
              } else {
                // Si el alumno reprobo el grado
                $('#msg_alumno').addClass('text-success');
                $('#msg_alumno').append('</br><span class="text-danger"><i class="fa fa-check-circle" style="margin-right: 3px;"></i> El estudiante reprobó <strong>'+data['grado']+'</strong></span>');
              }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            console.log('error');
        }
      });
    });
  })
</script>
@endsection