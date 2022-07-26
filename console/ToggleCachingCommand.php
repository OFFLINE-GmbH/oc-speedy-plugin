<?php namespace Offline\Speedy\Console;

use Illuminate\Console\Command;
use OFFLINE\Speedy\Models\Settings as SpeedySettings;

/**
 * ToggleCachingCommand
 */
class ToggleCachingCommand extends Command
{
    protected $name = 'speedy:toggle-caching';

    protected $signature = 'speedy:toggle-caching
                        {--enable : Whether to try to enable instead of toggling}
                        {--disable : Whether to try to disable instead of toggling}';

    protected $description = 'Enable Caching';

    public function handle()
    {
        if ($this->option('enable')) {
            if (SpeedySettings::get('enable_caching')) {
                $this->info('Caching is already enabled.');

                return;
            }

            SpeedySettings::set(['enable_caching' => true]);

            $this->output->success('Caching is now enabled.');

            return;
        }

        if ($this->option('disable')) {
            if ( ! SpeedySettings::get('enable_caching')) {
                $this->info('Caching is already disabled.');

                return;
            }

            SpeedySettings::set(['enable_caching' => false]);

            $this->output->success('Caching is now disabled.');

            return;
        }


        if (SpeedySettings::get('enable_caching')) {
            if ($this->confirm('Caching is currently enabled, do you wish to disable it?')) {
                SpeedySettings::set(['enable_caching' => false]);

                $this->output->success('Caching is now disabled.');
            }
        } else {
            if ($this->confirm('Caching is currently disabled, do you wish to enable it?')) {
                SpeedySettings::set(['enable_caching' => true]);

                $this->output->success('Caching is now enabled.');
            }
        }
    }
}
