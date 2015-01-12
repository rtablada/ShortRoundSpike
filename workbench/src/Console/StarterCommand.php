<?php namespace Rtablada\ShortRound\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class StarterCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'shortround:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffolds new ShortRound CMS.';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    protected $starterBlueprintPath;

    /**
     * Create a new command instance.
     *
     * @return StarterCommand
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;

        $this->starterBlueprintPath = __DIR__ . '/../../blueprints/starter';
    }

    protected $ensureDirectories = [
        'resources/assets/less/admin',
    ];

    protected $blueprintFiles = [
        'gulpfile.js',
        'bower.json',
        'elixir.json',
        'resources/views/admin',
        'resources/assets/less',
        'database/seeds/DatabaseSeeder.php',
        'database/seeds/MenuSeeder.php',
        'app/Models/Menu.php',
    ];

    protected $bowerComponents = [
        'sb-admin-2/less/sb-admin-2.less' => 'resources/assets/less/admin/sb-admin-2.less',
        'sb-admin-2/less/variables.less'  => 'resources/assets/less/admin/sb-variables.less',
        'bootstrap/less/variables.less'  => 'resources/assets/less/admin/bootstrap-variables.less',
        'bootstrap/less/bootstrap.less'  => 'resources/assets/less/admin/bootstrap.less',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->file->deleteDirectory(base_path('resources/assets/less'));
        $this->file->deleteDirectory(app_path('Http/Controllers/Auth'));
        $this->file->delete([app_path('Http/Controllers/HomeController.php'), app_path('Http/Controllers/WelcomController.php')]);

        $this->file->put(app_path('Http/routes.php'), "<?php\n");

        $this->file->append(base_path('.gitignore'), "bower_components\n.vagrant\n.idea\nnode_modules\n");

        foreach ($this->ensureDirectories as $dir) {
            $this->file->makeDirectory($dir, 0755, true);
        }

        foreach ($this->blueprintFiles as $blueprint) {
            $this->copyBlueprint($blueprint);
        }

        passthru('cd ' . base_path() . ' && bower install && npm install && npm install gulp-concat --save-dev');

        foreach ($this->bowerComponents as $src => $dest) {
            $this->pullInBowerComponent($src, $dest);
        }

        $this->updateBootstrapImports();
        $this->updateSbAdminImports();

        passthru('cd ' . base_path() . ' && gulp');
    }

    protected function copyBlueprint($file)
    {
        $blueprintPath = $this->getBlueprint($file);

        if ($this->file->isDirectory($blueprintPath)) {
            $this->file->copyDirectory($this->getBlueprint($file), base_path($file));
        } else {
            $this->file->copy($this->getBlueprint($file), base_path($file));
        }
    }

    protected function getBlueprint($file)
    {
        return $this->starterBlueprintPath . '/' . $file;
    }

    protected function pullInBowerComponent($src, $destination)
    {
        $path = base_path('bower_components/' . $src);

        $this->file->copy($path, base_path($destination));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected
    function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected
    function getOptions()
    {
        return [
        ];
    }

    private function updateSbAdminImports()
    {
        $sbAdminPath = base_path('resources/assets/less/admin/sb-admin-2.less');
        $sbAdmin = $this->file->get($sbAdminPath);

        $sbAdmin = str_replace('variables.less', 'sb-variables.less', $sbAdmin);
        $sbAdmin = str_replace('@import "mixins.less";', '', $sbAdmin);

        $this->file->put($sbAdminPath, $sbAdmin);
    }

    private function updateBootstrapImports()
    {
        $bootstrapPath = base_path('resources/assets/less/admin/bootstrap.less');
        $bootstrap = $this->file->get($bootstrapPath);

        $bootstrap = str_replace('@import "', '@import "../../../../bower_components/bootstrap/less/', $bootstrap);
        $bootstrap = str_replace('@import "../../../../bower_components/bootstrap/less/variables', '@import "bootstrap-variables', $bootstrap);

        $this->file->put($bootstrapPath, $bootstrap);
    }

}
