<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class MakeInterfaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name} {--r} {--d} {--a}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an Interface class';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * arguments
     *
     * @var array
     */
    protected $arguments = [];

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
        $this->generateClassName();
        $this->checkArguments();
        $path = $this->getSourceFilePath();
        $this->makeDirectory(dirname($path));
        $contents = $this->getSourceFile();
        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("Interface file created successfully");
        } else {
            $this->info("Interface file already exits");
        }
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath()
    {
        return __DIR__ . './../../../stubs/Interface.stub';
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
            'NAMESPACE'         => 'App\\Interfaces',
            'CLASS_NAME'        => $this->className,
            'REQUESTS'          => $this->generateRequestStub(),
            'RESOURCES'         => $this->generateResourceStub(),
            'DATATABLES'        => $this->generateDatatableStub(),
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
        return 'app/Interfaces/' . $this->getSingularClassName($this->argument('name')) . 'Interface.php';
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

    /**
     * checkArguments
     *
     * @return void
     */
    public function checkArguments()
    {
        if ($this->option('r')) {
            array_push($this->arguments, 'RESOURCE');
            return;
        }

        if ($this->option('d')) {
            array_push($this->arguments, 'DATATABLE');
            return;
        }

        if ($this->option('a')) {
            array_push($this->arguments, 'RESOURCE');
            array_push($this->arguments, 'DATATABLE');
            return;
        }
    }

    /**
     * generateClassName
     *
     * @return void
     */
    protected function generateClassName()
    {
        $this->className = $this->getSingularClassName($this->argument('name'));
        return;
    }

    /**
     * generateRequestStub
     *
     * @return void
     */
    protected function generateRequestStub()
    {
        $isArgumentResource = in_array('RESOURCE', $this->arguments);
        return ($isArgumentResource) ? "\nuse App\Http\Requests\Store" . $this->className . "Request;\nuse App\Http\Requests\Update" . $this->className . "Request;\n" : null;
    }

    /**
     * generateResourceStub
     *
     * @return void
     */
    protected function generateResourceStub()
    {
        $isArgumentResource = in_array('RESOURCE', $this->arguments);
        if ($isArgumentResource) {
            return "\tpublic function get(array \$condition);\n\tpublic function getAll(array \$condition = []);\n\tpublic function store(Store" . $this->className . "Request \$request);\n\tpublic function update(Update" . $this->className . "Request \$request, array \$condition);\n\tpublic function destroy(array \$condition);\n";
        }

        return null;
    }

    /**
     * generateDatatableStub
     *
     * @return void
     */
    protected function generateDatatableStub()
    {
        $isArgumentDatatable = in_array('DATATABLE', $this->arguments);
        if ($isArgumentDatatable) {
            return "\tpublic function datatable(\$sourcedata = null);\n\tpublic function buildDatatableTable();\n\tpublic function buildDatatableScript();";
        }

        return null;
    }
}
