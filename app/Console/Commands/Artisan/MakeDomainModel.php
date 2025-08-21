<?php

namespace App\Console\Commands\Artisan;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str; // Ensure Str facade is imported

class MakeDomainModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:domain-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Domain Model in the DDD structure.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Domain Model';

    /**
     * Get the root namespace for the class.
     *
     * Overrides the default 'App' root namespace to 'Src'.
     * This is crucial for how the command understands your application's base namespace.
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
     * This method is overridden to directly return the fully qualified class name.
     * This bypasses GeneratorCommand's internal `qualifyClass` method entirely,
     * which seems to be the source of the memory exhaustion due to recursion/misinterpretation.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $domain = trim($this->argument('domain'));
        $modelName = trim($this->argument('name'));

        // Manually construct the full namespace based on our rootNamespace() and arguments.
        $namespace = $this->rootNamespace() . '\\Domain\\' . $domain . '\\Models';

        // Return the fully qualified class name, ensuring it's in StudlyCase.
        return $namespace . '\\' . Str::studly($modelName);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // This points to a 'stubs' directory in your project root
        return base_path('stubs/domain.model.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * This method is called by `buildClass` and `qualifyClass` to get the base namespace.
     * Because `rootNamespace()` is overridden, `$rootNamespace` here will be 'Src'.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $domain = trim($this->argument('domain'));
        // We use the passed $rootNamespace (which is 'Src') to build the expected namespace.
        return $rootNamespace.'\\Domain\\'.$domain.'\\Models';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name (This $name is now the fully qualified class name from getNameInput())
     * @return string
     */
    protected function getPath($name)
    {
        // 1. Remove the root namespace from the FQCN to get the path relative to the 'src/' directory.
        //    Example: 'Src\Domain\Mail\Models\Mail' becomes 'Domain\Mail\Models\Mail'.
        $relativePath = Str::after($name, $this->rootNamespace().'\\');

        // 2. Convert PHP namespace backslashes to file system forward slashes.
        $filePath = str_replace('\\', '/', $relativePath);

        // 3. Construct the full absolute path, starting from 'base_path('src/')'.
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
            ['domain', InputArgument::REQUIRED, 'The Domain name for the model (e.g., User, Product).'],
            ['name', InputArgument::REQUIRED, 'The name of the Domain Model.'],
        ];
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name (This $name is the fully qualified class name, e.g., 'Src\Domain\Mail\Models\Mail')
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        // Fix: Call replaceNamespace, but do NOT reassign $stub to its return value ($this).
        // replaceNamespace modifies $stub by reference, which is what we need.
        $this->replaceNamespace($stub, $this->getNamespace($name));

        // Now $stub correctly holds the modified string content.
        return $this->replaceClass($stub, class_basename($name));
    }

    /**
     * Get the namespace for the given class name.
     *
     * This method is crucial for `replaceNamespace` within `buildClass`.
     * It correctly extracts the namespace from a fully qualified class name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getNamespace($name)
    {
        // Explode the FQCN by backslash, remove the last part (the class name itself),
        // and then implode back to get the namespace.
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }
}