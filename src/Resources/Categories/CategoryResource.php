<?php

namespace SOSEventsBV\CrownCms\Resources\Categories;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SOSEventsBV\CrownCms\Models\Category;
use SOSEventsBV\CrownCms\Resources\Categories\Pages\CreateCategory;
use SOSEventsBV\CrownCms\Resources\Categories\Pages\EditCategory;
use SOSEventsBV\CrownCms\Resources\Categories\Pages\ListCategories;
use SOSEventsBV\CrownCms\Resources\Categories\Schemas\CategoryForm;
use SOSEventsBV\CrownCms\Resources\Categories\Tables\CategoriesTable;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedTag;
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|\UnitEnum|null $navigationGroup = "Producten";

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Categorie';
    protected static ?string $pluralModelLabel = 'Categorieën';
    protected static ?string $navigationLabel = 'Categorieën';

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
