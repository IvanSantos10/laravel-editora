<?php

namespace CodeEduUser\Http\Controllers;

use CodeEduUser\Annotations\Mapping as Permission;
use CodeEduUser\Http\Requests\UserDeleteRequest;
use CodeEduUser\Http\Requests\UserRequest;
use CodeEduUser\Repositories\RoleRepository;
use CodeEduUser\Repositories\UserRepository;


/**
 * Class UsersController
 * @package CodeEduUser\Http\Controllers
 * @Permission\Controller(name="user-admin", description="Administracão de Usuários")
 */
class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * UsersController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository, RoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
    }


    /**
     * Display a listing of the resource.
     * @Permission\Action(name="list", description="Ver listagem de usuários")
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->paginate(10);
        return view('codeeduuser::users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @Permission\Action(name="store", description="Criar usuários")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepository->all()->pluck('name', 'id');
        return view('codeeduuser::users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @Permission\Action(name="store", description="Criar usuários")
     * @param  \CodeEduUser\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->repository->create($request->all());
        $url = $request->get('redirect_to', route('codeeduuser.users.index'));
        $request->session()->flash('message', 'Usuário cadastrado com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @Permission\Action(name="update", description="Atualizar usuários")
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param User $user
     */
    public function edit($id)
    {
        $user = $this->repository->find($id);
        $roles = $this->roleRepository->all()->pluck('name', 'id');
        return view('codeeduuser::users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @Permission\Action(name="update", description="Atualizar usuários")
     * @param \CodeEduUser\Http\Requests\UserRequest|\Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param User $user
     * @internal param int $id
     */
    public function update(UserRequest $request, $id )
    {
        $data = $request->except(['password']);
        $this->repository->update($data, $id);
        $url = $request->get('redirect_to', route('codeeduuser.users.index'));
        $request->session()->flash('message', 'Usuário alterado com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @Permission\Action(name="destroy", description="Excluir usuários")
     * @param UserDeleteRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param User $user
     * @internal param int $id
     */
    public function destroy(UserDeleteRequest $request, $id)
    {
        $this->repository->delete($id);
        \Session::flash('message', 'Usuário excluído com sucesso.');
        return redirect()->to(\URL::previous());
    }
}
