
{!! Form::open(array('url' => 'notas', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search', 'class' => 'form-inline')) !!}
  <!-- Año -->

  <div class="form-group">
    <div class="input-group">
      <label for="">Período </label>
      {!! Form::select('anio_search', $anios, $anio->id, ['class' => 'form-control select2', 'placeholder' => '-- Seleccione un período --']) !!}
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success">
          <i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </span>
    </div>
  </div>

  {{-- <div class="form-group">
    <div class="input-group">
      <select name="anio_search" id="anio_id" class="form-control select2">
        <option value="">Seleccione período</option>
        @foreach ($anios as $anio)
          <option value="{{$anio->id}}">{{$anio->numero}}</option>
        @endforeach
      </select>
      
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success">
          <i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </span>
    </div>
  </div> --}}
{!! Form::close() !!}
