<?php

namespace Anaseqal\NovaImport;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaImport extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-import', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-import', __DIR__.'/../dist/css/tool.css');
    }
}
