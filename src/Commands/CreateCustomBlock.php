<?php

namespace SOSEventsBV\CrownCms\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateCustomBlock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crown-cms:create-custom-block {name? : The name of the block}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Crown CMS custom block.';

    /**
     * @throws FileNotFoundException
     */
    public function handle()
    {
        // Get the block name, if not given, ask
        $blockName = $this->argument('name');
        if(!$blockName) $blockName = $this->ask('What is the name of the block?');

        // Ask label
        $label = $this->ask('What should the label be of the component?');

        $className = Str::endsWith($blockName, 'Block') ? $blockName : $blockName . 'Block';
        $viewName = 'components.crown-cms.custom-blocks.' . Str::kebab($className);

        $customBlocksDirectory = app_path('CrownCms/CustomBlocks');
        $customBlockFilePath = $customBlocksDirectory . '/' . $className . '.php';

        $componentDirectory = app_path('View/Components/CrownCms/CustomBlocks');
        $componentFilePath = $componentDirectory . '/' . $className . '.php';

        $viewDirectory = resource_path('views/components/crown-cms/custom-blocks');
        $viewFilePath = $viewDirectory . '/' . Str::kebab($className) . '.blade.php';

        // Check if any of the files already exist
        if (File::exists($customBlockFilePath) || File::exists($componentFilePath) || File::exists($viewFilePath)) {
            $this->error('Custom block already exists.');
            return self::FAILURE;
        }

        // Create folders if they don't exist
        foreach ([$customBlocksDirectory, $componentDirectory, $viewDirectory] as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, recursive: true);
            }
        }

        // Create files
        File::put($customBlockFilePath, $this->createCrownCmsCustomBlock($className, $label));
        File::put($componentFilePath, $this->createCustomBlockComponentClass($className, $viewName));
        File::put($viewFilePath, $this->createCustomBlockView($label));

        $this->newLine();
        $this->components->info("Custom block [{$className}] created successfully.");
        $this->components->bulletList([
            'Block: ' . Str::after($customBlockFilePath, base_path() . '/'),
            'Component: ' . Str::after($componentFilePath, base_path() . '/'),
            'View: ' . Str::after($viewFilePath, base_path() . '/'),
        ]);

        return self::SUCCESS;
    }

    /**
     * @throws FileNotFoundException
     */
    private function createCrownCmsCustomBlock(string $className, string $label): array|string
    {
        $stubPath = __DIR__ . '/../../stubs/custom-block.stub';

        $stub = File::get($stubPath);

        $replacements = [
            '{{ namespace }}' => 'App\CrownCms\CustomBlocks',
            '{{ class }}' => $className,
            '{{ blockKey }}' => Str::snake($className),
            '{{ label }}' => $label,
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $stub);
    }

    /**
     * @throws FileNotFoundException
     */
    private function createCustomBlockComponentClass(string $className, string $viewName): array|string
    {
        $stubPath = __DIR__ . '/../../stubs/custom-block-component.stub';

        $stub = File::get($stubPath);

        $replacements = [
            '{{ namespace }}' => 'App\View\Components\CrownCms\CustomBlocks',
            '{{ class }}' => $className,
            '{{ view }}' => $viewName,
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $stub);
    }

    /**
     * @throws FileNotFoundException
     */
    private function createCustomBlockView(string $label): array|string
    {
        $stubPath = __DIR__ . '/../../stubs/custom-block-view.stub';

        $stub = File::get($stubPath);

        $replacements = ['{{ label }}' => $label];

        return str_replace(array_keys($replacements), array_values($replacements), $stub);
    }
}
