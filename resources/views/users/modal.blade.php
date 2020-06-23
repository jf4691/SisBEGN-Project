<div class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal-delete-{{ $user->id }}">
  {!! Form::open(array('action' => array('UserController@destroy', $user->id), 'method' => 'delete')) !!}
    <div class="modal-dialog modal-sm">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Baja de usuario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Está seguro que desea desactivar al usuario <b>{{ $user->nombre }} {{ $user->apellido }}</b>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Aceptar</button>
        </div>
      </div>
    </div>
  {!! Form::close() !!}
</div>