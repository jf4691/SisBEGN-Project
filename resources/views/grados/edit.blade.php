@extends('layouts.general')

@section('titulo', 'SISBEGN | Editar Grado')

@section('encabezado', 'Editar Grado')

@section('subencabezado', 'Editar')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-list"></i> Gestión Académica
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('docentes.index') }}">Grado</a>
</li>
<li class="breadcrumb-item active">
  Editar Grado
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Editar Grado</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => ['grados.update', $grado], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">

          <!-- Nivel Academico -->
          <div class="form-group row{{ $errors->has('nivel_id') ? ' has-error' : '' }}">
            {!! Form::label('nivel_id>', 'Nivel Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('nivel_id', $niveles, $grado->nivel_id,  ['class' => 'form-control', 'disabled', 'placeholder' => '-- Seleccione un nivel academico --', 'required']) !!}
              @if ($errors->has('nivel_id'))
              <span class="text-danger">{{ $errors->first('nivel_id') }}</span>
              @endif
            </div>
          </div>

        <!-- Anio -->
          <div class="form-group row{{ $errors->has('anio_id') ? ' has-error' : '' }}">
            {!! Form::label('numero>', 'Período Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('anio_id', $anios, $grado->anio_id, ['class' => 'form-control', 'disabled', 'placeholder' => '-- Seleccione un Año --', 'required']) !!}
              @if ($errors->has('anio_id'))
              <span class="text-danger">{{ $errors->first('anio_id') }}</span>
              @endif
            </div>
          </div>

          <!-- Código -->
          <div class="form-group row{{ $errors->has('codigo') ? ' has-error' : '' }}">
            {!! Form::label('Codigo', 'Código', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('codigo', $grado->codigo, ['class' => 'form-control', 'placeholder' => 'Codigo del Grado', 'required', 'disabled']) !!}
                @if ($errors->has('codigo'))
                <span class="text-danger">{{ $errors->first('codigo') }}</span>
                @endif
            </div>
          </div>

          <!-- Sección -->
          <div class="form-group row{{ $errors->has('seccion') ? ' has-error' : '' }}">
            {!! Form::label('Seccion', 'Seccion', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('seccion', $grado->seccion, ['class' => 'form-control', 'placeholder' => 'Seccion ', 'required', 'disabled']) !!}
                @if ($errors->has('seccion'))
                <span class="text-danger">{{ $errors->first('seccion') }}</span>
                @endif
            </div>
          </div>

          <!-- Docente orientador -->
          <div class="form-group row{{ $errors->has('docente_id') ? ' has-error' : '' }}">
            {!! Form::label('docente_id', 'Profesor Dirigente', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('docente_id', $docentes, $grado->docente_id, ['class' => 'form-control', 'placeholder' => '-- Seleccione un docente orientador --', 'required']) !!}
              @if ($errors->has('docente_id'))
              <span class="text-danger">{{ $errors->first('docente_id') }}</span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Estado</label>
            <div class="col-sm-5 check-group">
                <input type=checkbox name="estado" value="1" {{ $grado->estado == '1' ? 'checked' : ''}}> Activar
            </div>
          </div>

          <!-- Materias -->
          <div class="row">
            <div class="col-sm-offset-4 col-sm-12">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-quitar-margen">
                  <thead>
                    <tr>
                      <td colspan="2" class="color-template"><h6 style="color: #ffffff">ASIGNACIÓN DE DOCENTES A MATERIAS</h6></td>
                    </tr>
                    <tr>
                      <th>MATERIA</th>
                      <th>DOCENTE</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @if (isset($materias[0]->pivot->docente_id))
                      @foreach($materias as $materia)
                      <tr>
                        <td>
                          {!! Form::hidden('materias[]', $materia->id, ['class' => 'form-control', 'placeholder' => 'Seccion ', 'required']) !!}
                          {{ $materia->codigo }} - {{ $materia->nombre }}
                        </td>
                        <td>
                          {!! Form::select('docentes[]', $docentes, $materia->pivot->docente_id, ['class' => 'form-control', 'placeholder' => '-- Seleccione un docente --']) !!}
                        </td>
                      </tr>
                      @endforeach
                    @else
                      
                    {{-- Verificar si hay materias en dicho nivel --}}
                      @if ($materias->count() == 0)
                      <div class="alert alert-danger" role="alert">
                        Este NIVEL ACADEMICO no tiene materias asignadas.
                      </div>
                      @endif

                      @foreach($materias as $materia)
                      <tr>
                        <td>
                          {!! Form::hidden('materias[]', $materia->id, ['class' => 'form-control', 'placeholder' => 'Seccion ', 'required']) !!}
                          {{ $materia->codigo }} - {{ $materia->nombre }}
                        </td>
                        <td>
                          <select name="docentes[]" class="form-control">
                            <option value="">-- Seleccione un docente --</option>
                            @foreach($docentes as $key => $docente)
                            <option value="{{ $key }}" {{ ($materia->pivot->docente_id == $key) ? 'selected' : '' }}> {{ $docente }} </option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      @endforeach
                    @endif
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
              <a href="{{ route('grados.index') }}" class="btn btn-secondary">Cancelar</a>
              {!! Form::submit('Actualizar', ['class' => 'btn btn-success', ($materias->count() == 0) ? 'disabled' : '']) !!}
          </div>
        </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection