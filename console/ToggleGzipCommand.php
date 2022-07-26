<?php namespace Offline\Speedy\Console;

use Illuminate\Console\Command;
use OFFLINE\Speedy\Models\Settings as SpeedySettings;

/**
 * ToggleGzipCommand
 */
class ToggleGzipCommand extends Command
{
    protected $name = 'speedy:toggle-gzip';

    protected $signature = 'speedy:toggle-gzip
                        {--enable : Whether to try to enable instead of toggling}
                        {--disable : Whether to try to disable instead of toggling}';

    protected $description = 'Enable Gzip';

    public function handle()
    {
        if ($this->option('enable')) {
            if (SpeedySettings::get('enable_gzip')) {
                $this->info('Gzip is already enabled.');

                return;
            }

            SpeedySettings::set(['enable_gzip' => true]);

            $this->output->success('Gzip is now enabled.');

            return;
        }

        if ($this->option('disable')) {
            if ( ! SpeedySettings::get('enable_gzip')) {
                $this->info('Gzip is already disabled.');

                return;
            }

            SpeedySettings::set(['enable_gzip' => false]);

            $this->output->success('Gzip is now disabled.');

            return;
        }


        if (SpeedySettings::get('enable_gzip')) {
            if ($this->confirm('Gzip is currently enabled, do you wish to disable it?')) {
                SpeedySettings::set(['enable_gzip' => false]);

                $this->output->success('Gzip is now disabled.');
            }
        } else {
            if ($this->confirm('Gzip is currently disabled, do you wish to enable it?')) {
                SpeedySettings::set(['enable_gzip' => true]);

                $this->output->success('Gzip is now enabled.');
            }
        }
    }
}
