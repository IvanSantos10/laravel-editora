<?php

namespace CodeEduBook\Http\Controllers;

use CodeEduUser\Annotations\Mapping as Permission;
use Editora\Http\Controllers\Controller;
use CodeEduBook\Repositories\BookRepository;
use Illuminate\Http\Request;

/**
 * Class BooksTrashedController
 * @package CodeEduBook\Http\Controllers
 * @Permission\Controller(name="books-trashed-admin", description="Administracão de livros excluidos")
 */
class BooksTrashedController extends Controller
{
    /**
     * @var BookRepository
     */
    private $repository;

    /**
     * BooksController constructor.
     * @param \CodeEduBook\Repositories\BookRepository $repository
     */
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @Permission\Action(name="list", description="Listar livros excluidos")
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $this->repository->onlyTrashed();
        $books = $this->repository->paginate(10);

        return view('codeedubook::trashed.books.index', compact('books', 'search'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @Permission\Action(name="list", description="Listar livros excluidos")
     */
    public function show($id)
    {
        $this->repository->onlyTrashed();
        $book = $this->repository->find($id);

        return view('codeedubook::trashed.books.show', compact('book'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @Permission\Action(name="update", description="Restaurar livro da lixeira")
     */
    public function update(Request $request, $id)
    {
        $this->repository->onlyTrashed();
        $this->repository->restore($id);

        $url = $request->get('redirect_to', route('trashed.books.index'));
        $request->session()->flash('message', 'Livro restaurado com sucesso.');

        return redirect()->to($url);
    }
}
