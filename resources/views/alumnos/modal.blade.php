<div class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal-delete-{{ $alumno->id }}">
  {!! Form::open(array('action' => array('AlumnoController@destroy', $alumno->id), 'method' => 'delete')) !!}
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h6 class="modal-title">
          <b>
            @switch($alumno->darBaja)
              @case('yes')
                DAR DE BAJA
                @break
              @case('not')
                ATENCIÓN!
                @break
              @default
                ELIMINAR
                @break
            @endswitch
          </b> 
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        @switch($alumno->darBaja)
          @case('yes')
            <div class="alert alert-light style-modal-eliminar">El estudiante registra historial de notas y matrículas en el sistema 
            por lo que se procederá a inactivarlo.</div>
            <p>¿Está seguro que desea inactivar al estudiante <b>{{ $alumno->nombre }} {{ $alumno->apellido }}</b>?</p>
            @break
          @case('not')
            <div class="alert alert-light style-modal-eliminar">El estudiante seleccionado no se puede eliminar/inactivar porque tiene una matrícula activa</div>
            @break
          @default
            <p class="">¿Está seguro que desea eliminar al estudiante <b>{{ $alumno->nombre }} {{ $alumno->apellido }}</b>?</p>
            @break
        @endswitch
        <input type="hidden" name="matriculado" value="{{ $alumno->darBaja }}">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        @if ($alumno->darBaja != 'not')
        <button type="submit" class="btn btn-success">Aceptar</button>
        @endif
      </div>
    </div>
  </div>  
  
  {!! Form::close() !!}
</div>