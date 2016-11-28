@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de categorias</h3>
            {!! Button::primary('Nova categoria')->asLinkTo(route('categories.create')) !!}
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <ul class="list-inline">
                                <li>
                                    <a href="{{ route('categories.edit', ['category' => $category->id]) }}">Editar</a>
                                </li>
                                <li>|</li>
                                <li>
                                    <?php $deleteForm = "delete-form-{$loop->index}" ?>
                                    <a href="{{ route('categories.destroy', ['category' => $category->id]) }}"
                                        onclick="event.preventDefault(); document.getElementById('{{ $deleteForm }}').submit();">Excluir</a>
                                    {!! Form::open(['route' => ['categories.destroy', 'category' => $category->id],
                                        'id' => $deleteForm, 'method' => 'DELETE', 'style' => 'display:nome']) !!}
                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </thead>
            </table>

            {{ $categories->links() }}
        </div>
    </div>
@endsection
