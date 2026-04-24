<?php

namespace SOSEventsBV\CrownCms\Resources\FaqPageQuestions;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Models\FaqPageQuestion;
use SOSEventsBV\CrownCms\Resources\FaqPageQuestions\Pages\ManageFaqPageQuestions;

class FaqPageQuestionResource extends Resource
{
    protected static ?string $model = FaqPageQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'question';

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Vraag';
    protected static ?string $pluralModelLabel = 'Vragen';
    protected static ?string $navigationLabel = 'FAQ Pagina';

    protected static string|\UnitEnum|null $navigationGroup = "Pagina's";

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select, create, edit and delete FAQ categories
                Select::make('faq_page_category_id')
                    ->label('Categorie')
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        // Create a form for a category
                        TextInput::make('name')
                            ->label('Categorienaam')
                            ->required(),
                        RichEditor::make('description')
                            ->label('Categorieomschrijving (optioneel)')
                    ])
                    ->editOptionForm([
                        // Edit form for category
                        TextInput::make('name')
                            ->label('Categorienaam')
                            ->required(),
                        RichEditor::make('description')
                            ->label('Categorieomschrijving (optioneel)')
                    ])
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('question')
                    ->label('Vraag')
                    ->required()
                    ->columnSpanFull(),

                RichEditor::make('answer')
                    ->label('Antwoord')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('category.name')
                    ->label('Categorie'),

                TextColumn::make('question')
                    ->label('Vraag')
                    ->searchable(),

                TextColumn::make('answer')
                    ->label('Antwoord')
                    ->formatStateUsing(fn($state): string => strip_tags($state))
                    ->limit(75)
            ])
            ->filters([
                SelectFilter::make('faq_page_category_id')
                    ->label('Categorie')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->authorize(fn ($record) => Auth::user()->getRole() === UserRole::Admin),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->authorize(fn ($record) => Auth::user()->getRole() === UserRole::Admin),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFaqPageQuestions::route('/'),
        ];
    }
}
