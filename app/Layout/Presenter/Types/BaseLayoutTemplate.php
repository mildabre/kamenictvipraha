<?php

declare(strict_types=1);

namespace App\Layout\Presenter\Types;

use Bite\Template\LayoutTemplate;

class BaseLayoutTemplate extends LayoutTemplate
{
    public bool $renderUserContextMenu;
}