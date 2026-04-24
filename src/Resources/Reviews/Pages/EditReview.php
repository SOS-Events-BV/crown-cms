<?php

namespace SOSEventsBV\CrownCms\Resources\Reviews\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Resources\Reviews\ReviewResource;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->authorize(fn ($record) => Auth::user()->getRole() === UserRole::Admin),
        ];
    }
}
