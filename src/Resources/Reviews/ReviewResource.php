<?php

namespace SOSEventsBV\CrownCms\Resources\Reviews;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Models\Review;
use SOSEventsBV\CrownCms\Resources\Reviews\Pages\EditReview;
use SOSEventsBV\CrownCms\Resources\Reviews\Pages\ListReviews;
use SOSEventsBV\CrownCms\Resources\Reviews\Schemas\ReviewForm;
use SOSEventsBV\CrownCms\Resources\Reviews\Tables\ReviewsTable;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $recordTitleAttribute = 'firstname';

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->firstname . ' ' . $record->lastname;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['firstname', 'lastname'];
    }

    protected static string|\UnitEnum|null $navigationGroup = "Pagina's";

    public static function canCreate(): bool
    {
        // We can't create reviews, only edit/delete
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return ReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReviewsTable::configure($table);
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
            'index' => ListReviews::route('/'),
            'edit' => EditReview::route('/{record}/edit'),
        ];
    }
}
