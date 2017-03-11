@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de função</h3>
            {!! Button::primary('Novo papel de usuário')->asLinkTo(route('codeeduuser.roles.create')) !!}
        </div>
        <div class="row">

            {!!
                Table::withContents($roles->items())->striped()
                ->callback('Ações', function ($field, $role){
                    $linkEdit = route('codeeduuser.roles.edit', ['role' => $role->id]);
                    $linkDestroy = route('codeeduuser.roles.destroy', ['role' => $role->id]);
                    $linkEditPermission = route('codeeduuser.roles.permissions.edit', ['role' => $role->id]);
                    $deleteForm = "delete-form-{$role->id}";
                    $form =  Form::open(['route' => ['codeeduuser.roles.destroy', 'role' => $role->id],
                                'id' => $deleteForm, 'method' => 'DELETE', 'style' => 'display:nome']).
                                Form::close();
                    $anchorDestroy = Button::link('Excluir')
                                        ->asLinkTo($linkDestroy)->addAttributes([
                                            'onclick' => "event.preventDefault(); document.getElementById(\"{$deleteForm}\").submit();"
                                        ]);

                    return "<ul class=\"list-inline\">".
                                "<li>".Button::link('Editar')->asLinkto($linkEdit)."</li>".
                                "<li>|</li>".
                                "<li>$anchorDestroy</li>".
                                "<li>|</li>".
                                "<li>".Button::link('Permissões')->asLinkto($linkEditPermission)."</li>".
                            "</ul>".
                            $form;
                })
            !!}

            {{ $roles->links() }}
        </div>
    </div>
@endsection
