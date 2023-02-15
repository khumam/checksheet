<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {name} {--type=} {--model=} {--route=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate template view';

    /**
     * type
     *
     * @var mixed
     */
    protected $type = null;

    /**
     * model
     *
     * @var mixed
     */
    protected $model = null;

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * route
     *
     * @var mixed
     */
    protected $route = "";

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
        $this->checkArgument();
        $paths = $this->getSourceFilePath();
        $this->makeDirectory('resources/views/' . $this->argument('name'));

        if ($this->type != null) {
            foreach ($paths as $key => $value) {
                $contents = $this->getSourceFile($this->getStubPath()[$key]);
                if (!$this->files->exists($value)) {
                    $this->files->put($value, $contents);
                    $this->info(Str::ucfirst($key) . " view file created successfully");
                } else {
                    $this->info(Str::ucfirst($key) . " view file already exits");
                }
            }
        } else {
            $contents = $this->getSourceFile($this->getStubPath()['regular']);
            if (!$this->files->exists($paths['index'])) {
                $this->files->put($paths['index'], $contents);
                $this->info("View file created successfully");
            } else {
                $this->info("View file already exits");
            }
        }
        return 0;
    }

    public function checkArgument()
    {
        if ($this->option('type')) {
            $this->type = $this->option('type');
        }

        if ($this->option('model')) {
            $this->model = $this->option('model');
        }

        if ($this->option('route')) {
            $this->route = $this->option('route');
        }
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath()
    {
        return [
            'regular' => __DIR__ . './../../../stubs/View.stub',
            'index' => __DIR__ . './../../../stubs/ViewIndex.stub',
            'create' => __DIR__ . './../../../stubs/ViewCreate.stub',
            'edit' => __DIR__ . './../../../stubs/ViewEdit.stub',
            'show' => __DIR__ . './../../../stubs/ViewShow.stub',
        ];
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
        return [
            'VIEWNAME' => Str::ucfirst($this->argument('name')),
            'ROUTE' => $this->route
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile($path)
    {
        return $this->getStubContents($path, $this->getStubVariables());
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
        return [
            'index' => 'resources/views/' . $this->argument('name') . '/index.blade.php',
            'create' => 'resources/views/' . $this->argument('name') . '/create.blade.php',
            'edit' => 'resources/views/' . $this->argument('name') . '/edit.blade.php',
            'show' => 'resources/views/' . $this->argument('name') . '/show.blade.php',
        ];
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
}
