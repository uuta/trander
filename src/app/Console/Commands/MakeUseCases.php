<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeUseCases extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:use-cases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a use case file.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'UseCases';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  app_path() . '/Console/Stubs/make-use-cases.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\UseCases';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
