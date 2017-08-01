<?php

namespace CodeEduBook\Repositories;

use Editora\Criteria\CriteriaTrashedTrait;
use Editora\Repositories\RepositoryRestoreTrait;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeEduBook\Models\Chapter;

/**
 * Class ChapterRepositoryEloquent
 * @package namespace Editora\Repositories;
 */
class ChapterRepositoryEloquent extends BaseRepository implements ChapterRepository
{
    use CriteriaTrashedTrait, RepositoryRestoreTrait;


    protected $fieldSearchable = [
        'title' => 'like',
        'author.name' => 'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Chapter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
