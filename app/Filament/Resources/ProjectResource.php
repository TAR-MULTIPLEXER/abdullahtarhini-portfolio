<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')->required()->maxLength(255)
                            ->live(onBlur: true)->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                        Forms\Components\Select::make('type')
                            ->options(['web' => 'Web Application', 'hardware' => 'Hardware Project', 'desktop' => 'Desktop/POS System', 'telecom' => 'Telecommunication'])
                            ->required()->default('web')->live(),
                        Forms\Components\TextInput::make('category')->required()->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options(['completed' => 'Completed', 'ongoing' => 'Ongoing', 'academic' => 'University Project'])
                            ->required()->default('completed'),
                    ])->columns(2),

                Forms\Components\Section::make('Descriptions')
                    ->schema([
                        Forms\Components\Textarea::make('short_description')->required()->rows(3)->maxLength(500),
                        Forms\Components\RichEditor::make('full_description')->required()->columnSpanFull(),
                        Forms\Components\Textarea::make('gallery_description')->label('Gallery Description')->rows(2),
                    ]),

                // ✅ COVER IMAGE (Standard Filament Upload)
               // ✅ COVER IMAGE (Using Custom Base64 Upload Component)
Forms\Components\Section::make('Cover Image')
    ->schema([
        \App\Filament\Forms\Components\Base64ImageUpload::make('cover_image')
            ->label('Cover Image')
           
            ->columnSpanFull()
            ->helperText('Stored as Base64 in the database.'),
    ]),

                // ✅ GALLERY IMAGES
             // ✅ GALLERY IMAGES (Using Custom Base64 Upload Component)
Forms\Components\Section::make('Gallery Images')
    ->schema([
        Forms\Components\Repeater::make('image_details')
            ->label('Gallery Images')
            ->schema([
                \App\Filament\Forms\Components\Base64ImageUpload::make('image')
                    ->label('Image')
                    ,
                Forms\Components\Textarea::make('description')->label('Description')->rows(2),
            ])
            ->collapsible()
            ->itemLabel(fn (array $state): ?string => $state['description'] ?? null)
            ->maxItems(30)
            ->columnSpanFull(),
    ]),

                // ✅ PDF DOCUMENTS
                Forms\Components\Section::make('PDF Documents')
                    ->schema([
                        Forms\Components\Repeater::make('pdfs')
                            ->label('PDFs')
                            ->schema([
                                Forms\Components\TextInput::make('title')->label('Title')->required()->maxLength(255)->columnSpan(1),
                                Forms\Components\FileUpload::make('path')
                                    ->label('PDF File')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->directory('projects/pdfs')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->required()
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->itemLabel(fn (array $state): string => $state['title'] ?? 'PDF')
                            ->maxItems(10)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Links & Tools')
                    ->schema([
                        Forms\Components\TextInput::make('github_link')->label('GitHub')->url(),
                        Forms\Components\TextInput::make('live_link')->label('Live Demo')->url(),
                        Forms\Components\TextInput::make('tools_used')->label('Technologies')->placeholder('Laravel, MySQL, etc.'),
                    ])->columns(2),
            ]);
    }

 protected static function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
{
    // Cover Image
    if (!empty($data['cover_image']) && str_starts_with($data['cover_image'], 'data:image')) {
        $data['cover_image_data'] = $data['cover_image'];
        unset($data['cover_image']);
    } else {
        unset($data['cover_image']);
    }

    // Gallery Images
    if (!empty($data['image_details']) && is_array($data['image_details'])) {
        $cleanGallery = [];
        foreach ($data['image_details'] as $img) {
            if (!empty($img['image']) && str_starts_with($img['image'], 'data:image')) {
                $cleanGallery[] = [
                    'image_data' => $img['image'],
                    'description' => $img['description'] ?? null,
                ];
            } elseif (!empty($img['image_data'])) {
                $cleanGallery[] = $img; // Keep existing base64 on edit
            }
        }
        $data['image_details'] = json_encode($cleanGallery, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } else {
        $data['image_details'] = null;
    }

    // PDFs
    if (!empty($data['pdfs']) && is_array($data['pdfs'])) {
        $data['pdfs'] = json_encode(array_values($data['pdfs']), JSON_UNESCAPED_SLASHES);
    } else {
        $data['pdfs'] = null;
    }

    return static::getModel()::create($data);
}

protected static function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
{
    // Copy the exact same logic as create
    if (!empty($data['cover_image']) && str_starts_with($data['cover_image'], 'data:image')) {
        $data['cover_image_data'] = $data['cover_image'];
        unset($data['cover_image']);
    } else {
        unset($data['cover_image']);
    }

    if (!empty($data['image_details']) && is_array($data['image_details'])) {
        $cleanGallery = [];
        foreach ($data['image_details'] as $img) {
            if (!empty($img['image']) && str_starts_with($img['image'], 'data:image')) {
                $cleanGallery[] = [
                    'image_data' => $img['image'],
                    'description' => $img['description'] ?? null,
                ];
            } elseif (!empty($img['image_data'])) {
                $cleanGallery[] = $img;
            }
        }
        $data['image_details'] = json_encode($cleanGallery, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } else {
        $data['image_details'] = null;
    }

    if (!empty($data['pdfs']) && is_array($data['pdfs'])) {
        $data['pdfs'] = json_encode(array_values($data['pdfs']), JSON_UNESCAPED_SLASHES);
    } else {
        $data['pdfs'] = null;
    }

    $record->update($data);
    return $record;
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('type')->colors(['warning'=>'hardware','danger'=>'desktop','info'=>'telecom','success'=>'web']),
                Tables\Columns\BadgeColumn::make('status')->colors(['gray'=>'academic','success'=>'completed','warning'=>'ongoing']),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(['web'=>'Web','hardware'=>'Hardware','desktop'=>'Desktop','telecom'=>'Telecom']),
                Tables\Filters\SelectFilter::make('status')->options(['completed'=>'Completed','ongoing'=>'Ongoing','academic'=>'Academic']),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}