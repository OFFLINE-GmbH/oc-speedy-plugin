<?php namespace Offline\Speedy\Console;

use Illuminate\Console\Command;
use OFFLINE\Speedy\Models\Settings as SpeedySettings;

/**
 * EnableGzipCommand
 */
class EnableGzipCommand extends Command
{
    protected $name = 'speedy:enable-gzip';

    protected $description = 'Enable Gzip';

    public function handle()
    {
        if (SpeedySettings::get('enable_gzip')) {
            $this->info('Gzip is already enabled.');

            return;
        }

        SpeedySettings::set(['enable_gzip' => true]);

        $this->output->success('Gzip is now enabled.');
    }
}
