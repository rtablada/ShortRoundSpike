<?php namespace Rtablada\ShortRound\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Twig_Environment;
use Twig_Loader_Filesystem;

use Rtablada\ShortRound\Generator\GeneratorInput;

class ResourceGeneratorCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'shortround:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffolds new ShortRound CMS resource from json file.';

    public function fire()
    {

        $data = $this->getJsonFileData();
        $input = new GeneratorInput($data);

        $this->loadTwig(__DIR__ . '/../../blueprints/stubs');

        $this->generateMigration($input->migrationName, $input);
        $this->generateModel($input->modelPath, $input);
        $this->generateGateway($input->gatewayPath, $input);
//        $this->generateController($input->controllerPath, $input);
//        $this->generateViews($input->viewsDir, $input);

//        $this->generateRoutes($input);
    }

    protected function getJsonFileData()
    {
        $jsonFile = \File::get($this->argument('json'));

        return json_decode($jsonFile, true);
    }

    protected function generateController($outputPath, GeneratorInput $data)
    {
        $value = $this->twig->render('controller.php', $data->toArray());

        \File::put(app_path($outputPath), $value);
    }

    protected function generateModel($outputPath, GeneratorInput $data)
    {
        $value = $this->twig->render('model.php', $data->toArray());

        \File::put(app_path($outputPath), $value);
    }

    protected function generateGateway($outputPath, GeneratorInput $data)
    {
        $value = $this->twig->render('gateway.php', $data->toArray());

        \File::put(app_path($outputPath), $value);
    }

    protected function generateViews($viewsDir, GeneratorInput $data)
    {
        if (!\File::exists($viewsDir)) {
            \File::makeDirectory(base_path($viewsDir));
        }
        $index = $this->twig->render('index.blade.php', $data->toArray());

        \File::put(base_path($viewsDir) . '/index.blade.php', $index);

        $form = $this->twig->render('form.blade.php', $data->toArray());

        \File::put(base_path($viewsDir) . '/form.blade.php', $form);
    }

    protected function generateRoutes(GeneratorInput $data)
    {
        $value = $this->twig->render('routes.php', $data->toArray());

        $this->info("Add this to the admin group in your routes.php file\n");
        $this->info($value);
    }

    protected function loadTwig($subsDir)
    {
        $this->loader = new Twig_Loader_Filesystem($subsDir);

        $this->twig = new Twig_Environment($this->loader);
    }

    private function generateMigration($fileName, $data)
    {
        $fileName = $this->migrationPath($fileName);

        $value = $this->twig->render('migration.php', $data->toArray());

        \File::put($fileName, $value);
    }

    protected function migrationPath($fileName)
    {
        return app('path.database') . '/migrations/' . $this->getDatePrefix() . '_' . $fileName . '.php';
    }

    /**
     * Get a date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['json', InputArgument::REQUIRED, 'Relative path to JSON file describing resource.'],
        ];
    }
}
