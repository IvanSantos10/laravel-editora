{!! Form::hidden('redirect_to', URL::previous()) !!}

{!! Html::openFormGroup('title', $errors) !!}
{!! Form::label('title', 'Título', ['class' => 'control-label']) !!}
{!! Form::text('title', null, ['class' => 'form-control']) !!}
{!! Form::error('title', $errors) !!}
{!! Html::closeFormGroup() !!}

{!! Html::openFormGroup('subtitle', $errors) !!}
{!! Form::label('subtitle', 'Subtítulo', ['class' => 'control-label']) !!}
{!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
{!! Form::error('subtitle', $errors) !!}
{!! Html::closeFormGroup() !!}

{!! Html::openFormGroup('price', $errors) !!}
{!! Form::label('price', 'Preço', ['class' => 'control-label']) !!}
{!! Form::text('price', null, ['class' => 'form-control']) !!}
{!! Form::error('price', $errors) !!}
{!! Html::closeFormGroup() !!}

{!! Html::openFormGroup('user_id', $errors) !!}
{!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
{!! Form::text('user_id', null, ['class' => 'form-control']) !!}
{!! Form::error('user_id', $errors) !!}
{!! Html::closeFormGroup() !!}