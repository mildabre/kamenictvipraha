<?php

declare(strict_types=1);

namespace App\Presentation\Error\RequestError;

use App\Presentation\Error\ServerError\ServerErrorPresenter;
use Bite\Presenter\AbstractPresenter;
use Bite\Support\Tools;
use Nette\Application\Request;
use ReflectionClass;
use ReflectionException;

/**
 * @mixin RequestErrorPresenter|ServerErrorPresenter
 */
trait DebugPanelData
{
    private function getDebugPanelData(Request $request): array
    {
        $exception = $request->getParameter('exception');
        $lastSegment = strrchr($exception::class, '\\');
        $classShortName = $lastSegment !== false ? substr($lastSegment, 1) : $exception::class;
        $message = $exception->getMessage();

        $presenter = $request->getParameter('previousPresenter');
        $printLink = $presenter instanceof AbstractPresenter;
        $caption = '';
        $href = '';

        if ($printLink) {
            try {
                $rc = new ReflectionClass($presenter);
                $file = $rc->getFileName();
                $caption = Tools::stripBasePath($file, $this->config->appDir);
                $href = '//open/?file='.urlencode($file).'&line=1';                     // prefix editor: in latte template, fix Latte protection

            } catch (ReflectionException) {
                $printLink = false;
            }
        }

        return [$printLink, $href, $caption, $classShortName, $message];
    }
}