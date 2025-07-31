<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use YlsIdeas\FeatureFlags\Facades\Features;

class GenerateFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feature:generate {--force=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shortcut command to generate list of feature with enable or disable state for development purpose';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $option = strtolower($this->option('force'));
        if ($option != null) {
            if (!in_array($option, ['on', 'off'])) {
                throw new \ErrorException('Feature option force must be ON or OFF');
            }
        }

        $features = config('features.feature_list');
        $appMode = config('app.env');
        foreach ($features as $feature => $opt) {
            switch ($appMode) {
                case 'production':
                    $this->turnFeatureOnOff($option == null ? $opt['production'] : $option, $feature);
                    break;
                case 'dev':
                case 'development':
                    $this->turnFeatureOnOff($option == null ? $opt['development'] : $option, $feature);
                    break;
                case 'local':
                    $this->turnFeatureOnOff($option == null ? $opt['local'] : $option, $feature);
                    break;
                default:
                    $this->info('Can\'t read app environment!');
                    break;
            }
        }

        $this->info(count($features) .' fetures generated succesfully!');
    }

    private function turnFeatureOnOff($mode, $feature)
    {
        // $this->info($feature .' Swithced into ' .($mode == 'on' ? 'on' : 'off'));
        if ($mode == 'on') {
            Features::turnOn($feature);
        } else {
            Features::turnOff($feature);
        }
    }
}
