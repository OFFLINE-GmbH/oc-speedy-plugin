<?php namespace Offline\Speedy\Console;

use Illuminate\Console\Command;
use OFFLINE\Speedy\Models\Settings as SpeedySettings;

/**
 * StatusCommand
 */
class StatusCommand extends Command
{
    protected $name = 'speedy:status';

    protected $description = 'Get the current Speedy settings';

    public function handle()
    {
        $headers = ['Setting', 'Value'];

        $values = [
            ['HTTP/2 preloading', SpeedySettings::get('http2_enabled') ? 'Enabled' : 'Disabled'],
            ['Gzip', SpeedySettings::get('enable_gzip') ? 'Enabled' : 'Disabled'],
            ['Caching', SpeedySettings::get('enable_caching') ? 'Enabled' : 'Disabled'],
        ];

        $this->table($headers, $values);
    }
}
