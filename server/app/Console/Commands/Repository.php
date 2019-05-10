<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Repository
 * @package App\Console\Commands
 */
class Repository extends Command
{
    const BASE_PATH = 'app/Repositories/';
    const ABSTRACT_SUFFIX = 'Interface';
    const CONCRETE_SUFFIX = '';
    const NAMESPACE_PATH_HEAD = 'App\\Repositories\\';

    /** @var string  */
    private $namespacePathHead;

    /** @var string */
    private $abstractSuffix;

    /** @var string */
    private $concreteSuffix;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repositoryName : The name of the repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository files.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->namespacePathHead = self::NAMESPACE_PATH_HEAD;
        $this->abstractSuffix = self::ABSTRACT_SUFFIX;
        $this->concreteSuffix = self::CONCRETE_SUFFIX;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $repositoryName = $this->argument('repositoryName');

        if ($repositoryName === '' || is_null($repositoryName) || empty($repositoryName)) {
            $this->error('Repository name invalid..!');
        }

        if (!file_exists(self::BASE_PATH . $repositoryName)) {

            mkdir(self::BASE_PATH . $repositoryName, 0775, true);

            $directory = self::BASE_PATH . $repositoryName . '/';
            $abstractFileName = $directory . $repositoryName . 'Repository' . self::ABSTRACT_SUFFIX . '.php';
            $concreteFileName = $directory . $repositoryName . 'Repository' . self::CONCRETE_SUFFIX . '.php';

            if (!file_exists($abstractFileName) && !file_exists($concreteFileName)) {
                file_put_contents($abstractFileName, $this->getAbstractFileContent($repositoryName));
                file_put_contents($concreteFileName, $this->getConcreteFileContent($repositoryName));

                $this->info('Repository files created successfully.');

            } else {
                $this->error('Repository files already exists.');
            }
        }
    }

    /**
     * @param string $repositoryName
     * @return string
     */
    private function getAbstractFileContent($repositoryName)
    {
        $abstractFileContent = <<< CONTENT
<?php

namespace {$this->namespacePathHead}{$repositoryName};

/**
 * Interface {$repositoryName}Repository{$this->abstractSuffix}
 */
interface {$repositoryName}Repository{$this->abstractSuffix}
{

}
CONTENT;

        return $abstractFileContent;
    }

    /**
     * @param string $repositoryName
     * @return string
     */
    private function getConcreteFileContent($repositoryName)
    {
        $concreteFileContent = <<< CONTENT
<?php

namespace {$this->namespacePathHead}{$repositoryName};

use {$this->namespacePathHead}{$repositoryName}\\{$repositoryName}Repository{$this->abstractSuffix};

/**
 * Class {$repositoryName}Repository{$this->concreteSuffix}
 */
class {$repositoryName}Repository{$this->concreteSuffix} implements {$repositoryName}Repository{$this->abstractSuffix}
{

}
CONTENT;

        return $concreteFileContent;
    }
}
