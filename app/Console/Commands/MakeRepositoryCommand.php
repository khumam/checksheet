<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a Repository class';

    /**
     * model
     *
     * @var mixed
     */
    protected $model;

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * className
     *
     * @var mixed
     */
    protected $className;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->checkArgument()) {
            $this->info("Model is required. Add --model parameter");
            return;
        }

        $this->generateClassName();
        $path = $this->getSourceFilePath();
        $this->makeDirectory(dirname($path));
        $contents = $this->getSourceFile();
        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("Repository file created successfully");
        } else {
            $this->info("Repository file already exits");
        }
    }

    /**
     * checkArgument
     *
     * @return void
     */
    public function checkArgument()
    {
        if ($this->option('model')) {
            $this->model = ucfirst($this->option('model'));
            return true;
        }

        return false;
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath()
    {
        return __DIR__ . './../../../stubs/Repository.stub';
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        $className = $this->getSingularClassName($this->argument('name'));
        return [
            'NAMESPACE'         => 'App\\Repositories',
            'CLASS_NAME'        => $this->className,
            'MODEL'             => $this->model,
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }


    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return 'app/Repositories/' . $this->getSingularClassName($this->argument('name')) . 'Repository.php';
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    protected function generateClassName()
    {
        $this->className = $this->getSingularClassName($this->argument('name'));
        return;
    }
}
