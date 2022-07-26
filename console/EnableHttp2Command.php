<?php namespace Offline\Speedy\Console;

use Illuminate\Console\Command;
use OFFLINE\Speedy\Models\Settings as SpeedySettings;

/**
 * EnableHttp2Command
 */
class EnableHttp2Command extends Command
{
    protected $name = 'speedy:enable-http2';

    protected $description = 'Enable HTTP/2 preloading';

    public function handle()
    {
        if (SpeedySettings::get('http2_enabled')) {
            $this->info('HTTP/2 is already enabled.');

            return;
        }

        SpeedySettings::set(['http2_enabled' => true]);

        $this->output->success('HTTP/2 preloading is now enabled.');
    }
}
