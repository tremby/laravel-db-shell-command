<?php
namespace Tremby\DbShellCommand;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->commands([
            Command\DbShellCommand::class,
        ]);
    }
}
