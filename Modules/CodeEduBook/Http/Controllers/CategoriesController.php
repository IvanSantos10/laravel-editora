<?php

namespace CodeEduBook\Http\Controllers;

use CodeEduUser\Annotations\Mapping as Permission;
use CodeEduBook\Http\Requests\CategoryRequest;
use CodeEduBook\Repositories\CategoryRepository;

/**
 * Class CategoriesController
 * @package CodeEduBook\Http\Controllers
 *@Permission\Controller(name="categories-admin", description="Administracão de categorias")
 */
class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoriesController constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @Permission\Action(name="list", description="Listar de categorias")
     */
    public function index()
    {
        $categories = $this->repository->paginate(10);
        return view('codeedubook::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @Permission\Action(name="store", description="Cadastrar categoria")
     */
    public function create()
    {
        return view('codeedubook::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \CodeEduBook\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     * @Permission\Action(name="store", description="Cadastrar categoria")
     */
    public function store(CategoryRequest $request)
    {
        $this->repository->create($request->all());
        $url = $request->get('redirect_to', route('categories.index'));
        $request->session()->flash('message', 'Categoria cadastrada com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Category $category
     * @Permission\Action(name="update", description="Editar categoria")
     *
     */
    public function edit($id)
    {
        $category = $this->repository->find($id);
        return view('codeedubook::categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \CodeEduBook\Http\Requests\CategoryRequest|\Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Category $category
     * @internal param int $id
     * @Permission\Action(name="update", description="Editar categoria")
     */
    public function update(CategoryRequest $request, $id )
    {
        $this->repository->update($request->all(), $id);
        $url = $request->get('redirect_to', route('categories.index'));
        $request->session()->flash('message', 'Categoria alterada com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Category $category
     * @internal param int $id
     * @Permission\Action(name="destroy", description="Excluir categoria")
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        \Session::flash('message', 'Categoria excluída com sucesso.');
        return redirect()->to(\URL::previous());
    }
}
