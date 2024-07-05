<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use RalphJSmit\Filament\SEO\SEO;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()->make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->helperText(new HtmlString('<a href="http://localhost:8000/admin/posts">http://localhost:8000/admin/posts/1/edit</a>'))
                                    ->maxLength(255),
                                RichEditor::make('content')
                                    ->required(),
                            ]),
                        Forms\Components\Section::make("SEO")->make()
                            ->schema([
                                SEO::make(['title', 'description']),
                            ])
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')->make()
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->reactive()
                                    ->default(true)
                                    ->required()
                            ]),
                        Forms\Components\Section::make('Collection')->make()
                            ->schema([
                                Forms\Components\Select::make('post_collection_id')
                                    ->relationship('postCollection', 'title')
                                    ->preload()
                                    ->required(),
                                // Forms\Components\Select::make('collections')
                                //     ->relationship('tags', 'name')
                                //     ->preload()
                                //     ->required(),
                            ]),
                        Forms\Components\Section::make('Cover')->make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('cover')
                                    ->image()
                                    ->imageEditor()
                                    ->responsiveImages()
                                    ->conversion('thumb')
                                    ->required(),
                            ])
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                SpatieMediaLibraryImageColumn::make('cover'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('is_active')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'In Active' => 'gray',
                        'Active' => 'success',
                    })
                    ->label('Status')
                    ->getStateUsing(function ($record) {
                        return $record->is_active ? 'Active' : 'In Active';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
