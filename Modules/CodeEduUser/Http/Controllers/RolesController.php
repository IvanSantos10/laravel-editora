<?php

namespace CodeEduUser\Http\Controllers;

use CodeEduUser\Annotations\Mapping\Controller as ControllerAnnotation;
use CodeEduUser\Annotations\Mapping\Action as ActionAnnotation;
use CodeEduUser\Criteria\FindPermissionsGroupCriteria;
use CodeEduUser\Criteria\FindPermissionsResourceCriteria;
use CodeEduUser\Http\Requests\RoleDeleteRequest;
use CodeEduUser\Http\Requests\RoleRequest;
use CodeEduUser\Repositories\PermissionRepository;
use CodeEduUser\Repositories\RoleRepository;
use Doctrine\DBAL\Query\QueryException;


/**
 * Class RolesController
 * @package CodeEduUser\Http\Controllers
 * @ControllerAnnotation(name="user-admin", description="Administracão de Funções")
 */
class RolesController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $repository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * RolesController constructor.
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository)
    {
        $this->repository = $repository;
        $this->permissionRepository = $permissionRepository;
    }


    /**
     * Display a listing of the resource.
     * @ActionAnnotation(name="list", description="Ver listagem de usuários")
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->repository->paginate(10);
        return view('codeeduuser::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @ActionAnnotation(name="create", description="criacão de usuários")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('codeeduuser::roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @ActionAnnotation(name="store", description="Cadastrar usuários")
     * @param  \CodeEduUser\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->repository->create($request->all());
        $url = $request->get('redirect_to', route('codeeduuser.roles.index'));
        $request->session()->flash('message', 'Papel de usuário cadastrado com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Role $role
     */
    public function edit($id)
    {
        $role = $this->repository->find($id);
        return view('codeeduuser::roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \CodeEduUser\Http\Requests\RoleRequest|\Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Role $role
     * @internal param int $id
     */
    public function update(RoleRequest $request, $id )
    {
        $this->repository->update($request->all(), $id);
        $url = $request->get('redirect_to', route('codeeduuser.roles.index'));
        $request->session()->flash('message', 'Papel de usuário alterado com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Role $role
     * @internal param int $id
     */
    public function destroy(RoleDeleteRequest $request, $id)
    {
        try {
            $this->repository->delete($id);
            \Session::flash('message', 'Papel de usuário excluido com sucesso.');
        }catch (QueryException $ex){
            \Session::flash('error', 'Papel de usuário não pode ser excluido. Ele está relacionado com outro registro .');
        }

        return redirect()->to(\URL::previous());
    }

    public function editPermission($id)
    {
        $role = $this->repository->find($id);

        $this->permissionRepository->pushCriteria(new FindPermissionsResourceCriteria());
        $permissions = $this->permissionRepository->all();

        $this->permissionRepository->resetCriteria();
        $this->permissionRepository->pushCriteria(new FindPermissionsGroupCriteria());
        $permissionsGroup = $this->permissionRepository->all(['name', 'description']);

        return view('codeeduuser::roles.permissions', compact('role', 'permissions', 'permissionsGroup'));
    }

    public function updatePermission($id)
    {

    }
}
