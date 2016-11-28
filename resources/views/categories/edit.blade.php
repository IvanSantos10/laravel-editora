@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Editar categorias</h3>

            {!! Form::model($category,[
                'route' => ['categories.update' , 'category' => $category->id],
                'class' => 'form', 'method' => 'PUT']) !!}

                @include('categories._form')

                {!! Html::openFormGroup() !!}
                    {!! Form::submit('Criar categoria', ['class' => 'btn btn-primary']) !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
