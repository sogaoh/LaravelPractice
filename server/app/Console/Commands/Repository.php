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

        list($directory, $repositoryShortName) = $this->decideRepositoryPathString($repositoryName);
        $abstractFileName = $directory . $repositoryShortName . 'Repository' . self::ABSTRACT_SUFFIX . '.php';
        $concreteFileName = $directory . $repositoryShortName . 'Repository' . self::CONCRETE_SUFFIX . '.php';

        if (!file_exists($abstractFileName) && !file_exists($concreteFileName)) {

            if (!file_exists(self::BASE_PATH . $repositoryName)) {
                mkdir($directory, 0775, true);
            }
            file_put_contents($abstractFileName, $this->getAbstractFileContent($repositoryName));
            file_put_contents($concreteFileName, $this->getConcreteFileContent($repositoryName));

            $this->info('Repository files created successfully.');

        } else {
            $this->error('Repository files already exists.');
        }
    }

    /**
     * @param string $repositoryName
     * @return string
     */
    private function getAbstractFileContent($repositoryName)
    {
        list($repositoryNamespacePath, $repositoryShortName) = $this->decideRepositoryNamespaceString($repositoryName);
        $abstractFileContent = <<< CONTENT
<?php

namespace {$repositoryNamespacePath};

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
        list($repositoryNamespacePath, $repositoryShortName) = $this->decideRepositoryNamespaceString($repositoryName);
        $concreteFileContent = <<< CONTENT
<?php

namespace {$repositoryNamespacePath};

use {$repositoryNamespacePath}\\{$repositoryShortName}Repository{$this->abstractSuffix};

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
     * @return array
     */
    private function decideRepositoryPathString($repositoryName)
    {
        $repositoryShortName = '';
        $repositoryNames = explode('/', $repositoryName);
        if (count($repositoryNames) > 1) {
            $directory = self::BASE_PATH;
            foreach ($repositoryNames as $name) {
                $directory .= $name . '/';
                $repositoryShortName = $name;
            }
        } else {
            $directory = self::BASE_PATH . $repositoryName . '/';
            $repositoryShortName = $repositoryName;
        }
        return array($directory, $repositoryShortName);
    }

    /**
     * リポジトリ名に / が含まれる場合を考慮してnamespace文字列を決定する
     *
     * @param $repositoryName
     * @return array
     */
    private function decideRepositoryNamespaceString($repositoryName)
    {
        $repositoryShortName = '';
        $repositoryNames = explode('/', $repositoryName);
        $nameCount = count($repositoryNames);
        if ($nameCount > 1) {
            $directory = self::NAMESPACE_PATH_HEAD;
            for ($i = 0; $i < $nameCount; $i++) {
                $name = $repositoryNames[$i];
                $directory .= $name;
                if ($i < $nameCount - 1) {
                    $directory .= '\\';
                }
                $repositoryShortName = $name;
            }
        } else {
            $directory = self::NAMESPACE_PATH_HEAD . $repositoryName;
            $repositoryShortName = $repositoryName;
        }
        return array($directory, $repositoryShortName);
    }
}
