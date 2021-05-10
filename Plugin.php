<?php namespace Sandbox\Uploader;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name'        => 'Uploader',
            'description' => 'Uploader demo',
            'author'      => 'Sandbox',
            'icon'        => 'icon-file'
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'uploader' => [
                'label'       => 'Uploader',
                'url'         => Backend::url('sandbox/uploader/ratesuploader'),
                'icon'        => 'icon-upload',
                'order'       => 500,
            ],
        ];
    }
}
