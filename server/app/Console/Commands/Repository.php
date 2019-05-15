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

            list($directory, $repositoryShortName) = $this->decideRepositoryPathString($repositoryName);

            mkdir($directory,0775,true);

            $abstractFileName = $directory . $repositoryShortName . 'Repository' . self::ABSTRACT_SUFFIX . '.php';
            $concreteFileName = $directory . $repositoryShortName . 'Repository' . self::CONCRETE_SUFFIX . '.php';

            if (!file_exists($abstractFileName) && !file_exists($concreteFileName)) {
                file_put_contents($abstractFileName, $this->getAbstractFileContent($repositoryName));
                file_put_contents($concreteFileName, $this->getConcreteFileContent($repositoryName));

                $this->info('Repository files created successfully.');

            } else {
                $this->error('Repository files already exists.');
            }
        } else {
            $this->error('Repository directory already exists.');
        }
    }

    /**
     * @param string $repositoryName
     * @return string
     */
    private function getAbstractFileContent($repositoryName)
    {
        list($repositoryPath, $repositoryShortName) = $this->decideRepositoryPathString($repositoryName, '\\');
        $abstractFileContent = <<< CONTENT
<?php

namespace {$this->namespacePathHead}{$repositoryPath};

/**
 * Interface {$repositoryShortName}Repository{$this->abstractSuffix}
 */
interface {$repositoryShortName}Repository{$this->abstractSuffix}
{

}
CONTENT;

        return $abstractFileContent;
    }

    /**
     * @param $repositoryName
     * @return string
     */
    private function getConcreteFileContent($repositoryName)
    {
        list($repositoryPath, $repositoryShortName) = $this->decideRepositoryPathString($repositoryName, '\\');
        $concreteFileContent = <<< CONTENT
<?php

namespace {$this->namespacePathHead}{$repositoryPath};

use {$this->namespacePathHead}{$repositoryPath}\\{$repositoryShortName}Repository{$this->abstractSuffix};

/**
 * Class {$repositoryShortName}Repository{$this->concreteSuffix}
 */
class {$repositoryShortName}Repository{$this->concreteSuffix} implements {$repositoryShortName}Repository{$this->abstractSuffix}
{

}
CONTENT;

        return $concreteFileContent;
    }

    /**
     * リポジトリ名に / が含まれる場合を考慮してパス文字列を決定する
     *
     * @param $repositoryName
     * @param $separator
     * @return array
     */
    private function decideRepositoryPathString($repositoryName, $separator = '/')
    {
        $repositoryShortName = '';
        $repositoryNames = explode('/', $repositoryName);
        if (count($repositoryNames) > 1) {
            $directory = self::BASE_PATH;
            foreach ($repositoryNames as $name) {
                $directory .= $name . $separator;
                $repositoryShortName = $name;
            }
            if ($separator === '\\') {
                $directory = str_replace('/', '\\', $repositoryName);
            }
        } else {
            $directory = ($separator === '/' ? self::BASE_PATH . $repositoryName . $separator : $repositoryName);
            $repositoryShortName = $repositoryName;
        }
        return array($directory, $repositoryShortName);
    }
}
