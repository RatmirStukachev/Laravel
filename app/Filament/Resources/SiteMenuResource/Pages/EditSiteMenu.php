<?php

namespace App\Filament\Resources\SiteMenuResource\Pages;

use App\Filament\Resources\SiteMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteMenu extends EditRecord
{
    protected static string $resource = SiteMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
