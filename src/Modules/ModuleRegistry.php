<?php


namespace JBP\Framework\Modules;


use JBP\Framework\App;

class ModuleRegistry
{
    private $app;
    private $composer;
    private $modules = [];

    public function setApp(App $app)
    {
        $this->app = $app;
    }

    public function setComposer($composer)
    {
        $this->composer = $composer;
    }

    public function add(Contract $module)
    {
        $this->modules[] = $module;
    }

    public function run()
    {
        foreach ($this->modules as $module) {
            //
        }
    }
}
