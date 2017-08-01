@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de livros</h3>
            {!! Button::primary('Nova livro')->asLinkTo(route('books.create')) !!}
        </div>
        <div class="row">
            <h3>Listagen de livros</h3>
            {!! Form::model(compact('search'), ['class' => 'form-inline', 'method' => 'GET']) !!}
                {!! Form::label('search', 'Pesquisar por título: ', ['class' => 'control-label']) !!}
                {!! Form::text('search', null, ['class' => 'form-control']) !!}

                {!! Button::primary('Buscar')->submit() !!}
            {!! Form::close() !!}
        </div>
        <div class="row">

            {!! Table::withContents($books->items())->striped()
                ->callback('Ações', function ($field, $book){
                    $linkEdit = route('books.edit', ['book' => $book->id]);
                    $linkDestroy = route('books.destroy', ['book' => $book->id]);
                    $linkChapters = route('chapters.index', ['book' => $book->id]);
                    $deleteForm = "delete-form-{$book->id}";
                    $form =  Form::open(['route' => ['books.destroy', 'book' => $book->id],
                                'id' => $deleteForm, 'method' => 'DELETE', 'style' => 'display:nome']).
                                Form::close();
                    $anchorDestroy = Button::link('Ir para lixeira ')
                                        ->asLinkTo($linkDestroy)->addAttributes([
                                            'onclick' => "event.preventDefault(); document.getElementById(\"{$deleteForm}\").submit();"
                                        ]);
                    return "<ul class=\"list-inline\">".
                            "<li>".Button::link('Capítulo')->asLinkto($linkChapters)."</li>".
                            "<li>|</li>".
                            "<li>".Button::link('Editar')->asLinkto($linkEdit)."</li>".
                            "<li>|</li>".
                            "<li>$anchorDestroy</li>".
                            "</ul>".
                            $form;
                })
            !!}

            {{ $books->links() }}
        </div>
    </div>
@endsection
