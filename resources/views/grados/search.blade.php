{!! Form::open(array('url' => 'grados', 'method' => 'GET', 'autocomplete' => 'off', 'grado' => 'search', 'class' => 'form-inline')) !!}
  <!-- Periodo -->
  <div class="form-group">
    <select name="searchAnio" id="anio_id" class="form-control select2">
      <option value="">-- Filtrar por período --</option>
      @foreach ($anios as $anio)
        <option value="{{$anio->id}}">{{$anio->numero}}</option>
      @endforeach
    </select>
  </div>
  
  <div class="form-group">
    <div class="input-group">
      <input type="text" class="form-control" name="searchText", placeholder="Buscar", value="{{ $searchText }}"></input>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success">
          <i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </span>
    </div>
  </div>
{!! Form::close() !!}