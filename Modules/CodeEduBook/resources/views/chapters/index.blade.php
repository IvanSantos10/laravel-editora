@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Capítulo de {{$book->title}}</h3>
            {!! Button::primary('Nova capítulo')->asLinkTo(route('chapters.create', ['book' => $book->id])) !!}
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

            {!! Table::withContents($chapters->items())->striped()
                ->callback('Ações', function ($field, $chapter) use($book){
                    $linkEdit = route('chapters.edit', ['book' => $book->id, 'chapter' => $chapter->id]);
                    $linkDestroy = route('chapters.destroy', ['book' => $book->id, 'chapter' => $chapter->id]);
                    $deleteForm = "delete-form-{$chapter->id}";
                    $form =  Form::open(['route' =>
                                ['chapters.destroy', 'book' => $book->id, 'chapter' => $chapter->id],
                                'id' => $deleteForm, 'method' => 'DELETE', 'style' => 'display:nome']).
                                Form::close();
                    $anchorDestroy = Button::link('Ir para lixeira ')
                                        ->asLinkTo($linkDestroy)->addAttributes([
                                            'onclick' => "event.preventDefault(); document.getElementById(\"{$deleteForm}\").submit();"
                                        ]);
                    return "<ul class=\"list-inline\">".
                            "<li>".Button::link('Editar')->asLinkto($linkEdit)."</li>".
                            "<li>|</li>".
                            "<li>$anchorDestroy</li>".
                            "</ul>".
                            $form;
                })
            !!}

            {{ $chapters->links() }}
        </div>
    </div>
@endsection
