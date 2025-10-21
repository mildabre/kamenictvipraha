<?php

declare(strict_types=1);

namespace App\Modules\Error\RequestError;

use Bite\Template\LayoutTemplate;

class RequestErrorTemplate extends LayoutTemplate
{
    public string $title;
    public string $message;
    public string $classShortName;
    public string $layoutFileName;
    public string $homeHref;
    public bool $printIdeLink;
    public string $ideCaption;
    public string $ideHref;
}
