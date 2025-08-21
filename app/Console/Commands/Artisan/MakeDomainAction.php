<?php

namespace App\Console\Commands\Artisan;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class MakeDomainAction extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:domain-action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Domain Action in the DDD structure.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Domain Action';

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'Src';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $domain = trim($this->argument('domain'));
        $name = trim($this->argument('name'));

        $namespace = $this->rootNamespace() . '\\Domain\\' . $domain . '\\Actions';

        return $namespace . '\\' . Str::studly($name);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/domain.action.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $domain = trim($this->argument('domain'));
        return $rootNamespace.'\\Domain\\'.$domain.'\\Actions';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $relativePath = Str::after($name, $this->rootNamespace().'\\');
        $filePath = str_replace('\\', '/', $relativePath);
        return base_path('src/'.$filePath.'.php');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['domain', InputArgument::REQUIRED, 'The Domain name for the action (e.g., User, Order).'],
            ['name', InputArgument::REQUIRED, 'The name of the Domain Action.'],
        ];
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $this->replaceNamespace($stub, $this->getNamespace($name));
        return $this->replaceClass($stub, class_basename($name));
    }

    /**
     * Get the namespace for the given class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }
}