<?php

declare(strict_types=1);

namespace App\Layout\Components;

use Bite\Components\UI\Menu\ToggleMenu;

final class FrontMenu extends ToggleMenu
{
    protected const array MenuItems = [
        '@home' => 'Úvod',
        'hrbitovni-architektura' => 'Hřbitovní architektura',
        'renovace-restaurovani' => 'Renovace a restaurování',
        'pismo-gravirovani' => 'Písmo a gravírování',
        'socharska-tvorba' => 'Sochařská tvorba',
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