@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de livros</h3>

            {!! Form::open(['route' => 'books.store', 'class' => 'form']) !!}

                @include('codeedubook::books._form')

                {!! Html::openFormGroup() !!}
                    {!! Button::primary('Criar livro')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
