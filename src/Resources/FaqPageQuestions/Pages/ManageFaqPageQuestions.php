<?php

namespace SOSEventsBV\CrownCms\Resources\FaqPageQuestions\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use SOSEventsBV\CrownCms\Resources\FaqPageQuestions\FaqPageQuestionResource;

class ManageFaqPageQuestions extends ManageRecords
{
    protected static string $resource = FaqPageQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('showFAQPage')
                ->label('Toon FAQ pagina')
                ->icon(Heroicon::QuestionMarkCircle)
//                ->url(route('faq'))
                ->color('gray')
                ->openUrlInNewTab(),

            CreateAction::make(),
        ];
    }
}
