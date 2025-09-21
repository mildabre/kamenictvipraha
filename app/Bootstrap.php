<?php

declare(strict_types=1);

namespace App;

use Nette;
use Nette\Bootstrap\Configurator;

class Bootstrap
{
    private Configurator $configurator;
    private string $rootDir;

    public function __construct()
    {
        $this->rootDir = dirname(__DIR__);
        $this->configurator = new Configurator;
        $this->configurator->setTempDirectory($this->rootDir.'/temp');
    }

    public function bootWebApplication(): Nette\DI\Container
    {
        $this->initializeEnvironment();
        $this->setupContainer();
        return $this->configurator->createContainer();
    }

    public function initializeEnvironment(): void
    {
        //$this->configurator->setDebugMode('secret@23.75.345.200'); // enable for your remote IP
//        $this->configurator->setDebugMode(false);
        $this->configurator->enableTracy($this->rootDir.'/log');
    }

    private function setupContainer(): void
    {
        $configDir = $this->rootDir.'/config';

        $isLocalServer = getenv('SERVER_LOCATION') === 'MILOS_DEV_LOCAL';
        if($isLocalServer){
            $this->configurator->addConfig($configDir.'/local.neon');
            $this->setOpenBasedir();

        }else{
            $this->configurator->addConfig($configDir.'/staging.neon');
        }

        $this->configurator->addConfig($configDir.'/common.neon');
        $this->configurator->addConfig($configDir.'/services.neon');
    }

    private function setOpenBasedir(): void
    {
        $allowedDirs = [
            $this->rootDir,
            ini_get('upload_tmp_dir'),
            ini_get('opcache.file_cache'),
        ];
        ini_set('open_basedir', implode(';', $allowedDirs));
    }
}
