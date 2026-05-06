<?php

declare(strict_types=1);

namespace App\Presentation\Components\Layout\Types;

use Bite\Template\LayoutTemplate;

class FrontLayoutTemplate extends LayoutTemplate
{
    public bool $isProductionServer;
    public string $imagePath;
}