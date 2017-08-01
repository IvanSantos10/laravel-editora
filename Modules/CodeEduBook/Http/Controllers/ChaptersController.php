<?php

namespace CodeEduBook\Http\Controllers;

use CodeEduBook\Criteria\FindByAuthor;
use CodeEduBook\Criteria\FindByBook;
use CodeEduUser\Annotations\Mapping as Permission;
use CodeEduBook\Http\Requests\ChapterCreateRequest;
use CodeEduBook\Http\Requests\ChapterUpdateRequest;
use CodeEduBook\Repositories\ChapterRepository;
use CodeEduBook\Repositories\BookRepository;
use Illuminate\Http\Request;

/**
 * Class ChaptersController
 * @package CodeEduBook\Http\Controllers
 * @Permission\Controller(name="book-admin", description="Administracão de livros")
 */
class ChaptersController extends Controller
{
    /**
     * @var \CodeEduBook\Repositories\ChapterRepository
     */
    private $repository;
    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * ChaptersController constructor.
     * @param ChapterRepository $repository
     * @param BookRepository $bookRepository
     */
    public function __construct(ChapterRepository $repository, BookRepository $bookRepository)
    {
        $this->repository = $repository;
        $this->bookRepository = $bookRepository;
        $this->bookRepository->pushCriteria(new FindByAuthor());
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @Permission\Action(name="list", description="Listar livros")
     */
    public function index(Request $request, $id)
    {
        $book = $this->bookRepository->find($id);
        $search = $request->get('search');
        $this->repository->pushCriteria(new FindByBook($id));
        $chapters = $this->repository->paginate(10);

        return view('codeedubook::chapters.index', compact('chapters', 'search', 'book'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @Permission\Action(name="store", description="Cadastrar livro")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->bookRepository->lists('name', 'id'); //pluck
        return view('codeedubook::chapters.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @Permission\Action(name="store", description="Cadastrar livro")
     * @param ChapterCreateRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChapterCreateRequest $request)
    {
        $data = $request->all();
        $data['author_id'] = \Auth::user()->id;
        $this->repository->create($data);
        $url = $request->get('redirect_to', route('chapters.index'));
        $request->session()->flash('message', 'Livro cadastrada com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @Permission\Action(name="update", description="Atualizar livro")
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Chapter $book
     */
    public function edit($id)
    {
        $book = $this->repository->find($id);
        $this->bookRepository->withTrashed();
        $categories = $this->bookRepository->listsWithMutators('name_trashed', 'id');
        return view('codeedubook::chapters.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @Permission\Action(name="update", description="Atualizar livro")
     * @param ChapterUpdateRequest|Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Chapter $book
     * @internal param int $id
     */
    public function update(ChapterUpdateRequest $request, $id)
    {
        $data = $request->except(['author_id']);
        $this->repository->update($data, $id);
        $url = $request->get('redirect_to', route('chapters.index'));
        $request->session()->flash('message', 'Livro alterada com sucesso.');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @Permission\Action(name="destroy", description="Excluir livro")
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Chapter $book
     * @internal param int $id
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        \Session::flash('message', 'Livro excluída com sucesso.');
        return redirect()->to(\URL::previous());
    }
}
