@extends('layouts.general')

@section('titulo', 'SISBEGN | Administrativo')

@section('encabezado', 'Administrativo')

@section('subencabezado', 'Editar')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Personal
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('administrativos.index') }}">Administrativos</a>
</li>
<li class="breadcrumb-item active">
  Editar Administrativo
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Editar Administrativo</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => ['administrativos.update',$administrativo], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">

          <!-- ID del Usuario -->
          <div class="form-group row{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', 'Administrativo', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="user_id" class="form-control" id="user_id">
                @foreach($users as $us)
                  @if($us->id == $administrativo->user_id)
                    <option value="{{$us->id}}" selected>{{$us->apellido}} {{$us->nombre}}</option>
                  @else
                    <option value="{{$us->id}}">{{$us->apellido}} {{$us->nombre}}</option>
                  @endif 
                @endforeach
              </select>
              @if ($errors->has('user_id'))
              <span class="text-danger">{{ $errors->first('user_id') }}</span>
              @endif
            </div>
          </div>
        
        <!-- Fecha de nacimiento -->
        <div class="form-group row{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }} input-btn-alinear">
          {!! Form::label('fecha_nacimiento', 'Fecha de nacimiento *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5 input-group">
            {!! Form::text('fecha_nacimiento', \Carbon\Carbon::parse($administrativo->fecha_nacimiento)->format('d/m/Y'), ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required', 'data-inputmask' => '"alias": "dd/mm/yyyy"', 'data-mask']) !!}
            @if ($errors->has('fecha_nacimiento'))
            <span class="text-danger">{{ $errors->first('fecha_nacimiento') }}</span>
            @endif
          </div>
        </div>
        <!-- Dirección -->
        <div class="form-group row{{ $errors->has('direccion') ? ' has-error' : '' }}">
          {!! Form::label('direccion', 'Dirección', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            {!! Form::textarea('direccion', $administrativo->direccion, ['class' => 'form-control', 'placeholder' => 'Dirección de domicilio']) !!}
            @if ($errors->has('direccion'))
            <span class="text-danger">{{ $errors->first('direccion') }}</span>
            @endif
          </div>
        </div>
        <!-- Provincias -->
        <div class="form-group row{{ $errors->has('provincia_id') ? ' has-error' : '' }}">
          {!! Form::label('provincia_id', 'Provincia *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            {!! Form::select('provincia_id', $provincias, $administrativo->ciudad->provincia_id, ['class' => 'form-control', 'placeholder' => '-- Seleccione una provincia --', 'onchange' => 'cargarCiudades(this.value);', 'required']) !!}
            @if ($errors->has('provincia_id'))
            <span class="text-danger">{{ $errors->first('provincia_id') }}</span>
            @endif
          </div>
        </div>
        <!-- Ciudades -->
        <div class="form-group row{{ $errors->has('ciudad_id') ? ' has-error' : '' }}">
          {!! Form::label('ciudad_id', 'Ciudad *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            <select id='ciudad_id' name='ciudad_id' class='form-control' required>
              @foreach ($ciudades as $ciudad)
              @if ($ciudad->id == $administrativo->ciudad_id)
              <option selected="selected" value='{{ $administrativo->ciudad_id }}'>{{ $administrativo->ciudad->nombre }}</option>
              @elseif ($ciudad->provincia_id == $administrativo->ciudad->provincia_id)
              <option value='{{ $ciudad->id }}'>{{ $ciudad->nombre }}</option>
              @endif
              @endforeach
            </select>
            @if ($errors->has('ciudad_id'))
            <span class="text-danger">{{ $errors->first('ciudad_id') }}</span>
            @endif
          </div>
        </div>
        <!-- Género -->
        <div class="form-group row{{ $errors->has('genero') ? ' has-error' : '' }}">
          {!! Form::label('genero', 'Género *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            {!! Form::select('genero', ['F' => 'Femenino', 'M' => 'Masculino'], $administrativo->genero, ['class' => 'form-control', 'placeholder' => '-- Seleccione un género --', 'required'] ) !!}
            @if ($errors->has('genero'))
            <span class="text-danger">{{ $errors->first('genero') }}</span>
            @endif
          </div>
        </div>
        <!-- Teléfono -->
        <div class="form-group row{{ $errors->has('telefono') ? ' has-error' : '' }}">
          {!! Form::label('telefono', 'Teléfono *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            {!! Form::text('telefono', $administrativo->telefono, ['class' => 'form-control', 'placeholder' => 'Teléfono de contacto', 'required', 'maxlength' => '12']) !!}
            @if ($errors->has('telefono'))
            <span class="text-danger">{{ $errors->first('telefono') }}</span>
            @endif
          </div>
        </div>
        <!-- Cargo -->
          <div class="form-group row{{ $errors->has('cargo') ? ' has-error' : '' }}">
            {!! Form::label('cargo', 'Cargo', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('cargo', $administrativo->cargo, ['class' => 'form-control', 'placeholder' => 'Cargo del Administrativo', 'required']) !!}
                @if ($errors->has('cargo'))
                <span class="text-danger">{{ $errors->first('cargo') }}</span>
                @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Estado</label>
            <div class="col-sm-5 check-group">
                <input type="checkbox" name="estado" value="1" {{ $administrativo->estado == '1' ? 'checked' : ''}}> 
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('administrativos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
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
<script type="text/javascript">
// Funcion que se ejecuta al seleccionar una opcion del select de ciudades.
function cargarCiudades(valor)
{
  var arrayValores=new Array(
    @foreach ($ciudades as $ciudad)
    new Array({{ $ciudad->provincia_id }}, {{ $ciudad->id }}, "{{ $ciudad->nombre }}"),
    @endforeach
  );

  if(valor == 0)
  {
      // Desactivamos el select de ciudades.
      document.getElementById("ciudad_id").disabled = true;
  } else {
      // Eliminamos todos los posibles valores que contenga el select de ciudades.
      document.getElementById("ciudad_id").options.length = 0;

      // Añadimos los nuevos valores al select de ciudades.
      document.getElementById("ciudad_id").options[0] = new Option("-- Seleccione una ciudad --", "0");

      // Únicamente añadimos los ciudades que pertenecen al id de la ciudad seleccionado.
      for(i=0; i<arrayValores.length; i++)
      {
        if(arrayValores[i][0] == valor)
        {
          document.getElementById("ciudad_id").options[document.getElementById("ciudad_id").options.length] = new Option(arrayValores[i][2], arrayValores[i][1]);
        }
      }

      // Habilitamos el select de ciudades.
      document.getElementById("ciudad_id").disabled = false;
  }
}
</script>
<!-- InputMask -->
<script src="{{ asset('js/jquery.inputmask.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.date.extensions.js') }}"></script>
<script type="text/javascript">
  $(function () {
    $('[data-mask]').inputmask()
  })
</script>
@endsection