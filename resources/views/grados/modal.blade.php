<div class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal-delete-{{ $grado->id }}">
  {!! Form::open(array('action' => array('GradoController@destroy', $grado->id), 'method' => 'delete')) !!}
    <div class="modal-dialog modal-sm">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Baja de grado</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Está seguro que desea desactivar al Grado <b>{{ $grado->codigo }}</b>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Aceptar</button>
        </div>
      </div>
    </div>
  {!! Form::close() !!}
</div>