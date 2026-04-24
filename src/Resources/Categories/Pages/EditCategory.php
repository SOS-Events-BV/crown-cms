<?php

namespace SOSEventsBV\CrownCms\Resources\Categories\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Resources\Categories\CategoryResource;

class EditCategory extends EditRecord
{
    use HasPreviewModal;

    protected static string $resource = CategoryResource::class;

    protected function getPreviewModalView(): ?string
    {
        // This corresponds to resources/views/category.blade.php
        return 'category';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        // This changes the key in the preview to $category
        return 'category';
    }

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(), // This adds the preview button to the page
            DeleteAction::make()
                ->authorize(fn ($record) => Auth::user()->getRole() === UserRole::Admin),
        ];
    }
}
