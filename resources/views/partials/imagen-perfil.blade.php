<div class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal-imagen">
  {!! Form::open(['route' => ['actualizar-imagen', Auth::user()->id], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal']) !!}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">CAMBIAR IMAGEN DE PERFIL</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <!-- Imagen -->
          <div class="form-group row{{ $errors->has('imagen') ? ' has-error' : '' }}">
            {!! Form::label('imagen', 'Imagen', ['class' => 'col-sm-2 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-6">
              {!! Form::file('imagen', ['class' => 'input-alinear']) !!}
              @if ($errors->has('imagen'))
                <span class="text-danger">{{ $errors->first('imagen') }}</span>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </div>
  {!! Form::close() !!}
</div>