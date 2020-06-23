<div class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal-delete-{{ $matricula->id }}">
  {!! Form::open(array('action' => array('MatriculaController@destroy', $matricula->id), 'method' => 'delete')) !!}
    <div class="modal-dialog modal-md">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h5 class="modal-title"><b>ELIMINAR MATRÍCULA</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="alert alert-light" style="text-aligne:justify; font-size:10pt"><b>ATENCIÓN: </b>Esta acción procederá a ELIMINAR 
            la matrícula siempre y cuando el registro no tenga notas en el período actual, caso contrario no se eliminará.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Aceptar</button>
        </div>
      </div>
    </div>
  {!! Form::close() !!}
</div>