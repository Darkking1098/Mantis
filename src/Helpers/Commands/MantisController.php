<?php

namespace Mantis\Helpers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Mantis\Helpers\fs;

class MantisController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:mantis-controller {name} {--item=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $defaultMethods = [
        "ui_modify",
        "ui_view",
        "web_modify",
        "web_toggle",
        "web_delete",
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $item = $this->option('item');

        $controllerPath = app_path("Http/Controllers/{$name}.php");
        $controllerStub = File::get(__DIR__ . ('/Stubs/MantisController.stub'));
        $controllerContent = str_replace(['{{ class }}', '{{ item }}', '{{class}}', '{{item}}'], [basename($name), $item, basename($name), $item], $controllerStub);

        if (File::exists($controllerPath)) {
            $this->error('Controller already exists!');
            return;
        }

        fs::create_file($controllerPath);
        File::put($controllerPath, $controllerContent);
        $this->info('Controller created successfully.');
    }
}
