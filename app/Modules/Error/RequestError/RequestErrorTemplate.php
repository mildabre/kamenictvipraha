<?php

declare(strict_types=1);

namespace App\Modules\Error\RequestError;

use App\Layout\Presenter\Types\BaseLayoutTemplate;
use Exception;

class RequestErrorTemplate extends BaseLayoutTemplate
{
    public bool $forwarded;
    public Exception $exception;
    public int $code;
    public string $title;
    public string $message;
    public bool $debugMode;
    public bool $hasIdeLink;
    public string $ideLinkCaption;
    public string $ideLinkHref;
    public string $homeHref;
    public string $presenterName;
}
