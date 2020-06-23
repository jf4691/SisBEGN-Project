<div class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal-password">
  {!! Form::open(['route' => ['actualizar-password', Auth::user()->id], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal']) !!}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">CAMBIAR CONTRASEÑA</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Password -->
          <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', 'Contraseña', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-8">
              {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nueva contraseña']) !!}
              @if ($errors->has('password'))
              <span class="text-danger">{{ $errors->first('password') }}</span>
              @endif
            </div>
          </div>
          <!-- Confirmar password -->
          <div class="form-group row">
            {!! Form::label('password_confirmation', 'Confirmar contraseña', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-8">
              {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmar nueva contraseña']) !!}
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