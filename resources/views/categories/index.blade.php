@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de categorias</h3>
            <a href="{{ route('categories.create') }}" class="btn btn-primary"> Nova categoria</a>
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
                        <td><a href="{{ route('categories.edit', ['category' => $category->id]) }}">Editar</a></td>
                    </tr>
                @endforeach
                </tbody>
                </thead>
            </table>

            {{ $categories->links() }}
        </div>
    </div>
@endsection
