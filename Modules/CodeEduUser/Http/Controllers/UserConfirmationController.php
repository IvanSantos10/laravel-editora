<?php

namespace CodeEduUser\Http\Controllers;

use CodeEduUser\Repositories\UserRepository;
use Jrean\UserVerification\Traits\VerifiesUsers;

/**
 * Class UsersController
 * @package CodeEduUser\Http\Controllers
 */
class UserConfirmationController extends Controller
{
    use VerifiesUsers;
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UsersController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function redirectAfterVerification()
    {
        $this->loginUser();
        return route('codeeduuser.user_settings.edit');
    }

    private function loginUser()
    {
        $email = \Request::get('email');
        $user = $this->repository->findByField('email', $email)->first();
        \Auth::login($user);
    }

}
