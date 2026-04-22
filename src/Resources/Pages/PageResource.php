<?php

namespace SOSEventsBV\CrownCms\Resources\Pages;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use SOSEventsBV\CrownCms\Models\Page;
use SOSEventsBV\CrownCms\Resources\Pages\Pages\CreatePage;
use SOSEventsBV\CrownCms\Resources\Pages\Pages\EditPage;
use SOSEventsBV\CrownCms\Resources\Pages\Pages\ListPages;
use SOSEventsBV\CrownCms\Resources\Pages\Schemas\PageForm;
use SOSEventsBV\CrownCms\Resources\Pages\Tables\PagesTable;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'seo.page_title';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->seo->page_title;
    }

    protected static string|\UnitEnum|null $navigationGroup = "Pagina's";

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Pagina';
    protected static ?string $pluralModelLabel = 'Pagina\'s';
    protected static ?string $navigationLabel = 'Pagina\'s';

    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
