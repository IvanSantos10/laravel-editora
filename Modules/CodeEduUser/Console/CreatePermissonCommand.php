<?php

namespace CodeEduUser\Console;

use CodeEduUser\Annotations\PermissionReader;
use CodeEduUser\Repositories\PermissionRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreatePermissonCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'codeeduuser:make-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criação de permissões baseado em controllers e actions';
    /**
     * @var PermissionRepository
     */
    private $repository;
    /**
     * @var PermissionReader
     */
    private $reader;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PermissionRepository $repository, PermissionReader $reader)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->reader = $reader;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $permissions = $this->reader->getPermissions();
        foreach ($permissions as $permission){
            if(!$this->exitsPermission($permission)) {
                $this->repository->create($permission);
            }
        }
        $this->info("<info>Permissões carregadas</info>");
    }

    private function exitsPermission($permission)
    {
        $permission = $this->repository->findWhere([
            'name' => $permission['name'],
            'resource_name' => $permission['resource_name'],
        ])->first();
        return $permission != null;
    }


}
