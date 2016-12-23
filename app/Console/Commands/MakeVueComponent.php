<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeVueComponent extends Command
{

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new single file vue component';

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->getNameInput();
        $this->files->put(resource_path('/assets/js/components').'/'.$name.'.vue', $this->getStub());
        $this->info('Vue component created successfully.');

    }

    public function getStub()
    {
        return $this->files->get(__DIR__.'/stubs/vueComponent.stub');
    }

    /**
     * Get the desired component name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }
}
