


{!! Form::open(array('route' => ['notas.edit', $gra_mat], 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search', 'class' => 'form-inline')) !!}
  <!-- Trimestre -->
  <div class="form-group">
    <div class="input-group">
      {!! Form::text('search_alumno', '', ['class' => 'form-control', 'placeholder' => 'Buscar alumno'] ) !!}
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success">
          <i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </span>
    </div>
  </div>
{!! Form::close() !!}