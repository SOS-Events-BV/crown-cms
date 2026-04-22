<?php

namespace SOSEventsBV\CrownCms\FilamentComponents;

use SOSEventsBV\CrownCms\FilamentBlocks\ButtonGroupBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\ContentBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\CustomHtmlBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\DividerBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\FaqBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\FormBuilderBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\HeadingBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\ImageBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\ImageSliderBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\LeisureKingFrame;
use SOSEventsBV\CrownCms\FilamentBlocks\ReadMoreBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\TwoColumnBlock;
use SOSEventsBV\CrownCms\FilamentBlocks\VideoBlock;
use Filament\Forms\Components\Builder;

class ContentBuilder
{
    /**
     * Returns all standard content blocks, including TwoColumnBlock.
     *
     * @param string $directory The upload directory for image blocks (e.g. 'page').
     * @return array
     */
    public static function blocks(string $directory = 'page'): array
    {
        return [
            HeadingBlock::make(),
            ContentBlock::make(),
            ImageBlock::make($directory),
            FaqBlock::make(),
            ButtonGroupBlock::make(),
            VideoBlock::make(),
            DividerBlock::make(),
            TwoColumnBlock::make($directory),
            ImageSliderBlock::make($directory),
            FormBuilderBlock::make(),
            LeisureKingFrame::make(),
            ReadMoreBlock::make(),
            CustomHtmlBlock::make(),
        ];
    }

    /**
     * Returns blocks safe for use inside column builders (excludes TwoColumnBlock and FormBuilderBlock
     * to prevent infinite recursion and irrelevant blocks in columns).
     *
     * @param string $directory The upload directory for image blocks (e.g. 'page').
     */
    public static function columnBlocks(string $directory = 'page'): array
    {
        return [
            HeadingBlock::make(),
            ContentBlock::make(),
            ImageBlock::make($directory),
            FaqBlock::make(),
            ButtonGroupBlock::make(),
            VideoBlock::make(),
            DividerBlock::make(),
            ImageSliderBlock::make($directory),
            LeisureKingFrame::make(),
            ReadMoreBlock::make(),
            CustomHtmlBlock::make(),
        ];
    }

    /**
     * Reusable page content builder with all standard blocks.
     *
     * @param string $field The field name to bind the builder to.
     * @param string $directory The upload directory for image blocks (e.g. 'page').
     */
    public static function make(string $field = 'content', string $directory = 'page'): Builder
    {
        return Builder::make($field)
            ->label('Pagina inhoud')
            ->blocks(static::blocks($directory))
            ->blockIcons()
            ->blockPickerColumns(2)
            ->reorderableWithButtons()
            ->columnSpanFull();
    }
}
