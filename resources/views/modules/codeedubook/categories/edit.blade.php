@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Editar categorias</h3>

            {!! Form::model($category,[
                'route' => ['categories.update' , 'category' => $category->id],
                'class' => 'form', 'method' => 'PUT']) !!}

                @include('codeedubook::categories._form')

                {!! Html::openFormGroup() !!}
                    {!! Button::primary('Editar categoria')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
