<?php namespace Offline\Speedy\Console;

use Illuminate\Console\Command;
use OFFLINE\Speedy\Models\Settings as SpeedySettings;

/**
 * EnableCachingCommand
 */
class EnableCachingCommand extends Command
{
    protected $name = 'speedy:enable-caching';

    protected $description = 'Enable Caching';

    public function handle()
    {
        if (SpeedySettings::get('enable_caching')) {
            $this->info('Caching is already enabled.');

            return;
        }

        SpeedySettings::set(['enable_caching' => true]);

        $this->output->success('Caching is now enabled.');
    }
}
