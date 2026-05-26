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
use Illuminate\Http\UploadedFile;

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
                            ->helperText('Optional description for the image gallery'),
                    ]),

                // ===== PROJECT PDFs (Stored in Public Storage for now) =====
                Forms\Components\Section::make('Project Documents (PDFs)')
                    ->schema([
                        Forms\Components\Repeater::make('pdfs')
                            ->label('Upload PDF Documents')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Document Title')
                                    ->required()
                                    ->placeholder('e.g., User Manual')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                
                                Forms\Components\FileUpload::make('path')
                                    ->label('PDF File')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->directory('projects/pdfs')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->itemLabel(fn (array $state): string => $state['title'] ?? 'New PDF')
                            ->maxItems(10)
                            ->minItems(0)
                            ->columnSpanFull(),
                    ]),

                // ===== IMAGES & MEDIA (Base64 Storage) =====
                Forms\Components\Section::make('Images & Media')
                    ->schema([
                        // ===== COVER IMAGE (Base64) =====
                        Forms\Components\Field::make('cover_image')
                            ->label('Cover Image (for project card)')
                            ->view('filament.forms.components.plain-file-upload')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Recommended: 1200x675px (16:9). Stored in Database.'),
                        
                        // ===== Gallery Images (Base64) =====
                        Forms\Components\Repeater::make('image_details')
                            ->label('Gallery Images with Descriptions')
                            ->schema([
                                Forms\Components\Field::make('image')
                                    ->label('Image')
                                    ->view('filament.forms.components.plain-file-upload')
                                    ->required(),
                                
                                Forms\Components\Textarea::make('description')
                                    ->label('Image Description')
                                    ->rows(2)
                                    ->placeholder('Describe this screenshot...'),
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
                            ->helperText('Leave EMPTY for local/offline projects'),
                        
                        Forms\Components\TextInput::make('documentation_link')
                            ->label('Documentation Link')
                            ->url()
                            ->placeholder('https://drive.google.com/...'),
                        
                        Forms\Components\TextInput::make('tools_used')
                            ->label('Technologies/Tools')
                            ->placeholder('PHP, MySQL, Laravel, Arduino')
                            ->helperText('Separate with commas'),
                    ])->columns(2),

                // ===== TECHNICAL SPECIFICATIONS =====
                Forms\Components\Section::make('Technical Specifications')
                    ->schema([
                        Forms\Components\KeyValue::make('specifications')
                            ->label('Project Specifications')
                            ->keyLabel('Specification')
                            ->valueLabel('Value')
                            ->helperText('e.g., Voltage: 5V, Protocol: MQTT') 
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
                            ->helperText('Lower numbers appear first'),
                        
                        Forms\Components\Toggle::make('show_gallery_description')
                            ->label('Show Gallery Description')
                            ->default(true),
                    ])->columns(3),
            ]);
    }

    // ✅ HANDLE FILE UPLOAD ON CREATE (BASE64 STORAGE)
    protected static function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // 1. Handle Cover Image -> Convert to Base64
        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            $imageData = file_get_contents($data['cover_image']->getRealPath());
            $data['cover_image_data'] = base64_encode($imageData);
            $data['cover_image'] = null; // Clear path field
        }

        // 2. Handle Gallery Images -> Convert to Base64
        if (isset($data['image_details']) && is_array($data['image_details'])) {
            foreach ($data['image_details'] as &$imageDetail) {
                if (isset($imageDetail['image']) && $imageDetail['image'] instanceof UploadedFile) {
                    $imageData = file_get_contents($imageDetail['image']->getRealPath());
                    $imageDetail['image_data'] = base64_encode($imageData);
                    unset($imageDetail['image']); // Remove file object
                }
            }
            $data['image_details'] = json_encode($data['image_details']);
        }

        // 3. Handle PDFs (Standard Storage)
        if (isset($data['pdfs']) && is_array($data['pdfs'])) {
            foreach ($data['pdfs'] as &$pdf) {
                if (isset($pdf['path']) && $pdf['path'] instanceof UploadedFile) {
                    $file = $pdf['path'];
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('storage/projects/pdfs');
                    
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }
                    
                    if ($file->move($destinationPath, $filename)) {
                        $pdf['path'] = 'projects/pdfs/' . $filename;
                    }
                }
            }
            $data['pdfs'] = json_encode($data['pdfs']);
        }
        
        return static::getModel()::create($data);
    }

    // ✅ HANDLE FILE UPLOAD ON UPDATE (BASE64 STORAGE)
    protected static function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // 1. Handle Cover Image Update
        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            $imageData = file_get_contents($data['cover_image']->getRealPath());
            $data['cover_image_data'] = base64_encode($imageData);
            $data['cover_image'] = null;
        }

        // 2. Handle Gallery Images Update
        if (isset($data['image_details']) && is_array($data['image_details'])) {
            foreach ($data['image_details'] as &$imageDetail) {
                if (isset($imageDetail['image']) && $imageDetail['image'] instanceof UploadedFile) {
                    $imageData = file_get_contents($imageDetail['image']->getRealPath());
                    $imageDetail['image_data'] = base64_encode($imageData);
                    unset($imageDetail['image']);
                }
            }
            $data['image_details'] = json_encode($data['image_details']);
        }

        // 3. Handle PDFs Update
        if (isset($data['pdfs']) && is_array($data['pdfs'])) {
            foreach ($data['pdfs'] as &$pdf) {
                if (isset($pdf['path']) && $pdf['path'] instanceof UploadedFile) {
                    // Delete old PDF if exists
                    if (isset($pdf['path']) && is_string($pdf['path'])) {
                        $oldPath = public_path('storage/' . $pdf['path']);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    
                    $file = $pdf['path'];
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('storage/projects/pdfs');
                    
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }
                    
                    if ($file->move($destinationPath, $filename)) {
                        $pdf['path'] = 'projects/pdfs/' . $filename;
                    }
                }
            }
            $data['pdfs'] = json_encode($data['pdfs']);
        }
        
        $record->update($data);
        return $record;
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