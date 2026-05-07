<?php

declare(strict_types=1);

namespace App\Presentation\Components\Controls;

use Bite\Components\UI\Menu\ToggleMenu;

final class FrontMenu extends ToggleMenu
{
    protected const array MenuItems = [
        '@home' => 'Úvod',
        'renovace-restaurovani' => 'Renovace a restaurování',
        'socharska-tvorba' => 'Sochařská tvorba',
        'hrbitovni-architektura' => 'Hřbitovní architektura',
        'pismo-gravirovani' => 'Písmo a gravírování',
        '#kontakt' => 'Kontakt',
    ];

    public function getCurrentKey(): ?string
    {
        if ($this->presenter->name !== 'Front:Content') {
            return null;
        }

        return $this->sid ?? self::HomeKey;
    }
}