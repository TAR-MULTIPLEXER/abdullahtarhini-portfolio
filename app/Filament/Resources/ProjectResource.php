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
use Illuminate\Support\Facades\Storage; // ✅ Required for file deletion

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ===== BASIC INFORMATION =====
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => 
                                $set('slug', Str::slug($state))
                            ),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('type')
                            ->options([
                                'web' => 'Web Application',
                                'hardware' => 'Hardware Project',
                                'desktop' => 'Desktop/POS System',
                                'telecom' => 'Telecommunication',
                            ])
                            ->required()
                            ->default('web')
                            ->live()
                            ->helperText('POS/Desktop projects will show "Request Demo" instead of "Live Demo"'),
                        
                        Forms\Components\TextInput::make('category')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., POS System, IoT, Network Design'),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'completed' => 'Completed',
                                'ongoing' => 'Ongoing',
                                'academic' => 'University Project',
                            ])
                            ->required()
                            ->default('completed'),
                    ])->columns(2),

                // ===== DESCRIPTIONS =====
                Forms\Components\Section::make('Descriptions')
                    ->schema([
                        Forms\Components\Textarea::make('short_description')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Brief summary shown on project cards'),
                        
                        Forms\Components\RichEditor::make('full_description')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Detailed project description with features, technologies, etc.'),
                        
                        Forms\Components\Textarea::make('gallery_description')
                            ->label('Image Gallery Description')
                            ->rows(2)
                            ->helperText('Optional description for the image gallery (e.g., "Screenshots from the POS system")'),
                    ]),

                // ===== PROJECT PDFs =====
                Forms\Components\Section::make('Project Documents (PDFs)')
                    ->schema([
                        Forms\Components\Repeater::make('pdfs')
                            ->label('Upload PDF Documents')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Document Title')
                                    ->required()
                                    ->placeholder('e.g., User Manual, Technical Specs, Installation Guide')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                
                                Forms\Components\FileUpload::make('path')
                                    ->label('PDF File')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->directory('projects/pdfs')
                                    ->visibility('public')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->itemLabel(fn (array $state): string => $state['title'] ?? 'New PDF Document')
                            ->maxItems(10)
                            ->minItems(0)
                            ->columnSpanFull(),
                    ]),

                // ===== IMAGES & MEDIA =====
                Forms\Components\Section::make('Images & Media')
                    ->schema([
                        // ===== COVER IMAGE =====
                  Forms\Components\FileUpload::make('cover_image')
    ->label('Cover Image')
    ->directory('projects/covers')
    ->disk('public') // ✅ Use public disk directly
    ->required()
    ->columnSpanFull()
    // ✅ ONLY saveUploadedFileUsing - NO other methods!
    ->saveUploadedFileUsing(function ($file) {
        if (!$file) return null;
        return $file->store('projects/covers', 'public');
    }),
                        
                        // ===== Gallery Images with Descriptions =====
                        Forms\Components\Repeater::make('image_details')
                            ->label('Gallery Images with Descriptions')
                            ->schema([
                          Forms\Components\FileUpload::make('image')
    ->label('Image')
    ->directory('projects/gallery')
    ->disk('public')
    ->required()
    ->saveUploadedFileUsing(function ($file) {
        if (!$file) return null;
        return $file->store('projects/gallery', 'public');
    }),
                                
                                Forms\Components\Textarea::make('description')
                                    ->label('Image Description')
                                    ->rows(2)
                                    ->placeholder('Describe this screenshot/image...'),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['description'] ?? null)
                            ->maxItems(30)
                            ->minItems(0)
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('video_url')
                            ->label('Demo Video URL (YouTube/Vimeo)')
                            ->url()
                            ->placeholder('https://youtube.com/watch?v=...'),
                    ])->columns(1),

                // ===== LINKS & TOOLS =====
                Forms\Components\Section::make('Links & Tools')
                    ->schema([
                        Forms\Components\TextInput::make('github_link')
                            ->label('GitHub Repository')
                            ->url()
                            ->placeholder('https://github.com/username/repo'),
                        
                        Forms\Components\TextInput::make('live_link')
                            ->label('Live Demo Link')
                            ->url()
                            ->helperText('Leave EMPTY for local/offline projects (POS, Desktop apps)'),
                        
                        Forms\Components\TextInput::make('documentation_link')
                            ->label('Documentation Link')
                            ->url()
                            ->placeholder('https://drive.google.com/... or GitHub Wiki'),
                        
                        Forms\Components\TextInput::make('tools_used')
                            ->label('Technologies/Tools')
                            ->placeholder('PHP, MySQL, Laravel, Arduino, MATLAB')
                            ->helperText('Separate with commas'),
                    ])->columns(2),

                // ===== TECHNICAL SPECIFICATIONS =====
                Forms\Components\Section::make('Technical Specifications')
                    ->schema([
                        Forms\Components\KeyValue::make('specifications')
                            ->label('Project Specifications')
                            ->keyLabel('Specification')
                            ->valueLabel('Value')
                            ->helperText('e.g., Voltage: 5V, Protocol: MQTT, Database: MySQL') 
                            ->columnSpanFull(),
                    ]),

                // ===== DISPLAY SETTINGS =====
                Forms\Components\Section::make('Display Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Show on Homepage')
                            ->helperText('Featured projects appear in the homepage showcase'),
                        
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first (0 = highest priority)'),
                        
                        Forms\Components\Toggle::make('show_gallery_description')
                            ->label('Show Gallery Description')
                            ->default(true)
                            ->helperText('Display the gallery description on project detail page'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'warning' => 'hardware',
                        'danger' => 'desktop',
                        'info' => 'telecom',
                        'success' => 'web',
                    ]),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'academic',
                        'success' => 'completed',
                        'warning' => 'ongoing',
                    ]),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'web' => 'Web',
                        'hardware' => 'Hardware',
                        'desktop' => 'Desktop/POS',
                        'telecom' => 'Telecom',
                    ]),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'ongoing' => 'Ongoing',
                        'academic' => 'Academic',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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