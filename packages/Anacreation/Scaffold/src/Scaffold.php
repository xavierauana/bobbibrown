<?php

namespace Anacreation\Scaffold;

use Illuminate\Console\Command;

class Scaffold extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaffold {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold Model Collection Policy and Requests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        // Create model and controller
        $this->call('make:model', [
            'name' => $this->argument('name'),
            '-m'   => true,
            '-r'   => true,
        ]);


        // Create requests
        $this->call('make:request', [
            'name' => str_plural($this->argument('name')) . "\\" . "Store{$this->argument('name')}Request",
        ]);
        $this->call('make:request', [
            'name' => str_plural($this->argument('name')) . "\\" . "Update{$this->argument('name')}Request",
        ]);

        // Create Policy
        $this->call('make:policy', [
            'name' => "{$this->argument('name')}Policy"
        ]);
    }
}
