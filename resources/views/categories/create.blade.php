@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de categorias</h3>

            {!! Form::open(['route' => 'categories.store', 'class' => 'form']) !!}

                @include('categories._form')

                {!! Html::openFormGroup() !!}
                    {!! Form::submit('Criar categoria', ['class' => 'btn btn-primary']) !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
