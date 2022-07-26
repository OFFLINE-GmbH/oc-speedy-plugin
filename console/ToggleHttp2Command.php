<?php namespace Offline\Speedy\Console;

use Illuminate\Console\Command;
use OFFLINE\Speedy\Models\Settings as SpeedySettings;

/**
 * ToggleHttp2Command
 */
class ToggleHttp2Command extends Command
{
    protected $name = 'speedy:toggle-http2';

    protected $signature = 'speedy:toggle-http2
                        {--enable : Whether to try to enable instead of toggling}
                        {--disable : Whether to try to disable instead of toggling}';

    protected $description = 'Enable HTTP/2 preloading';

    public function handle()
    {
        if ($this->option('enable')) {
            if (SpeedySettings::get('http2_enabled')) {
                $this->info('HTTP/2 preloading is already enabled.');

                return;
            }

            SpeedySettings::set(['http2_enabled' => true]);

            $this->output->success('HTTP/2 preloading is now enabled.');

            return;
        }

        if ($this->option('disable')) {
            if ( ! SpeedySettings::get('http2_enabled')) {
                $this->info('HTTP/2 preloading is already disabled.');

                return;
            }

            SpeedySettings::set(['http2_enabled' => false]);

            $this->output->success('HTTP/2 preloading is now disabled.');

            return;
        }


        if (SpeedySettings::get('http2_enabled')) {
            if ($this->confirm('HTTP/2 preloading is currently enabled, do you wish to disable it?')) {
                SpeedySettings::set(['http2_enabled' => false]);

                $this->output->success('HTTP/2 preloading is now disabled.');
            }
        } else {
            if ($this->confirm('HTTP/2 preloading is currently disabled, do you wish to enable it?')) {
                SpeedySettings::set(['http2_enabled' => true]);

                $this->output->success('HTTP/2 preloading is now enabled.');
            }
        }
    }
}
