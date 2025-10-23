<?php

declare(strict_types=1);

namespace App\Layout\Presenter\Types;

use Bite\Template\LayoutTemplate;

class FrontLayoutTemplate extends LayoutTemplate
{
    public bool $isProductionServer;
    public string $photoPath;
}