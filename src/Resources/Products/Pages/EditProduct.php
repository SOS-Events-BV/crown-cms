<?php

namespace SOSEventsBV\CrownCms\Resources\Products\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Resources\Products\ProductResource;

class EditProduct extends EditRecord
{
    use HasPreviewModal;

    protected static string $resource = ProductResource::class;

    protected function getPreviewModalView(): ?string
    {
        // This corresponds to resources/views/products/show.blade.php
        return 'products.show';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        // This changes the key in the preview to $product
        return 'product';
    }

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(), // This adds the preview button to the product
            DeleteAction::make()
                ->authorize(fn ($record) => Auth::user()->getRole() === UserRole::Admin),
        ];
    }
}
