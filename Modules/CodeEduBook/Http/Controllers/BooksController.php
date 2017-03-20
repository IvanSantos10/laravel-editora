<?php

namespace CodeEduBook\Http\Controllers;

use CodeEduBook\Criteria\FindByAuthor;
use CodeEduUser\Annotations\Mapping as Permission;
use CodeEduBook\Http\Requests\BookCreateRequest;
use CodeEduBook\Http\Requests\BookUpdateRequest;
use CodeEduBook\Repositories\BookRepository;
use CodeEduBook\Repositories\CategoryRepository;
use Illuminate\Http\Request;

/**
 * Class BooksController
 * @package CodeEduBook\Http\Controllers
 * @Permission\Controller(name="book-admin", description="Administracão de livros")
 */
class BooksController extends Controller
{
    /**
     * @var \CodeEduBook\Repositories\BookRepository
     */
    private $repository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * BooksController constructor.
     * @param BookRepository $repository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(BookRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new FindByAuthor());
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @Permission\Action(name="list", description="Listar livros")
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $books = $this->repository->paginate(10);
        return view('codeedubook::books.index', compact('books', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @Permission\Action(name="store", description="Cadastrar livro")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->lists('name', 'id'); //pluck
        return view('codeedubook::books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @Permission\Action(name="store", description="Cadastrar livro")
     * @param BookCreateRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $request)
    {
        $data = $request->all();
        $data['author_id'] = \Auth::user()->id;
        $this->repository->create($data);
        $url = $request->get('redirect_to', route('books.index'));
        $request->session()->flash('message', 'Livro cadastrada com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @Permission\Action(name="update", description="Atualizar livro")
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Book $book
     */
    public function edit($id)
    {
        $book = $this->repository->find($id);
        $this->categoryRepository->withTrashed();
        $categories = $this->categoryRepository->listsWithMutators('name_trashed', 'id');
        return view('codeedubook::books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @Permission\Action(name="update", description="Atualizar livro")
     * @param BookUpdateRequest|Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Book $book
     * @internal param int $id
     */
    public function update(BookUpdateRequest $request, $id)
    {
        $data = $request->except(['author_id']);
        $this->repository->update($data, $id);
        $url = $request->get('redirect_to', route('books.index'));
        $request->session()->flash('message', 'Livro alterada com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @Permission\Action(name="destroy", description="Excluir livro")
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Book $book
     * @internal param int $id
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        \Session::flash('message', 'Livro excluída com sucesso.');
        return redirect()->to(\URL::previous());
    }
}
