<?php

namespace App\Filament\Support;

use App\Models\LinkTile;
use Filament\Forms;
use Filament\Tables;

/**
 * Shared form + table definition for the three LinkTile resources.
 *
 * Main tiles, the community row and the social icons are all rows in
 * link_tiles; they get one Filament resource each purely so every row has its
 * own drag-to-reorder list. The field definitions themselves live here so they
 * are written once.
 */
class LinkTileForm
{
    /**
     * Per-section defaults for a newly created tile, so adding one renders
     * sensibly before the admin touches any of the background fields.
     */
    private const DEFAULTS = [
        LinkTile::SECTION_MAIN => ['size' => 'cover', 'position' => 'top left'],
        LinkTile::SECTION_COMMUNITY => ['size' => '80%', 'position' => 'center'],
        LinkTile::SECTION_SOCIAL => ['size' => '70%', 'position' => 'center'],
    ];

    public static function schema(string $section): array
    {
        $defaults = self::DEFAULTS[$section];
        $isSocial = $section === LinkTile::SECTION_SOCIAL;

        return [
            Forms\Components\Hidden::make('section')
                ->default($section),

            Forms\Components\Section::make('Tile')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label($isSocial ? 'Accessible label' : 'Title')
                        ->helperText($isSocial
                            ? 'Not shown on the page. Read out by screen readers, e.g. "YouTube".'
                            : 'Shown on the tile, e.g. "GAMING". Typed in capitals to match the others.')
                        ->required(! $isSocial)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('url')
                        ->label('Links to')
                        ->url()
                        ->required()
                        ->maxLength(255)
                        ->placeholder('https://'),

                    Forms\Components\Toggle::make('open_in_new_tab')
                        ->label('Open in a new tab')
                        ->default(false),

                    Forms\Components\Toggle::make('active')
                        ->label('Show on the site')
                        ->default(true)
                        ->helperText('Turn off to pull the tile without deleting it. The rest of the row resizes to fill the gap.'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Background')
                ->description('The image sits behind the tile. Sizes and positions are plain CSS values.')
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Background image')
                        ->disk('public')
                        ->directory('tiles')
                        ->visibility('public')
                        /*
                         * Several tiles are animated GIFs. Do not add image
                         * editing/resizing options here: Filament re-encodes
                         * when they are on, which flattens the animation.
                         */
                        ->acceptedFileTypes([
                            'image/gif',
                            'image/png',
                            'image/jpeg',
                            'image/webp',
                            'image/svg+xml',
                        ])
                        ->maxSize(10240)
                        ->columnSpanFull(),

                    Forms\Components\ColorPicker::make('bg_color')
                        ->label('Background colour')
                        ->hex()
                        ->helperText('Shows through wherever the image does not cover.'),

                    Forms\Components\TextInput::make('bg_size')
                        ->label('Image size')
                        ->default($defaults['size'])
                        ->maxLength(255)
                        ->helperText('cover, 80%, 100% auto …'),

                    Forms\Components\TextInput::make('bg_position')
                        ->label('Image position')
                        ->default($defaults['position'])
                        ->maxLength(255)
                        ->helperText('center, top left, right …'),

                    Forms\Components\TextInput::make('bg_size_mobile')
                        ->label('Image size on mobile')
                        ->maxLength(255)
                        ->helperText('Leave blank to reuse the size above.'),

                    Forms\Components\TextInput::make('bg_position_mobile')
                        ->label('Image position on mobile')
                        ->maxLength(255)
                        ->helperText('Leave blank to reuse the position above.'),
                ])
                ->columns(2),

            Forms\Components\Hidden::make('sort_order')
                ->default(fn () => (LinkTile::query()->where('section', $section)->max('sort_order') ?? 0) + 1),
        ];
    }

    public static function columns(bool $showTitle = true): array
    {
        return array_values(array_filter([
            Tables\Columns\TextColumn::make('sort_order')
                ->label('#')
                ->sortable(),

            Tables\Columns\ImageColumn::make('image_path')
                ->label('Image')
                ->disk('public'),

            $showTitle
                ? Tables\Columns\TextColumn::make('title')->label('Title')->searchable()
                : null,

            Tables\Columns\TextColumn::make('url')
                ->label('Links to')
                ->searchable()
                ->limit(40),

            Tables\Columns\ColorColumn::make('bg_color')
                ->label('Colour'),

            Tables\Columns\IconColumn::make('active')
                ->label('Live')
                ->boolean(),
        ]));
    }
}
