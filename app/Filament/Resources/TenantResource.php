<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Settings;
use App\Filament\Resources\TenantResource\Pages;
use App\Filament\Resources\TenantResource\RelationManagers;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;


class TenantResource extends Resource
{
    protected static ?string $cluster = Settings::class;
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        // ->unique(table: Tenant::class, column: 'email', ignorable: null, ignoreRecord: true)
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('domain')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('photo_path')
                        ->disk('public') // Usar o disco 'public'
                        ->directory('tenants/photos') // Salvar na pasta 'pdfs' dentro do disco 'public'
                        ->preserveFilenames()
                        ->image()
                        ->deletable(true)
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('4:3')
                        ->imageEditor()
                        ->circleCropper()
                        ->downloadable()
                        ->previewable(true)
                        ->required(),

                    // Campo de cores
                    Forms\Components\Grid::make(6)->schema([ // Organiza as cores em 3 colunas
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Primary Color')
                            ->default('#3490dc')
                            ->required()
                            ->columnSpan(1),
                            
                        Forms\Components\ColorPicker::make('danger_color')
                            ->label('Danger Color')
                            ->default('#ff0022')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\ColorPicker::make('info_color')
                            ->label('Info Color')
                            ->default('#00bcd4')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\ColorPicker::make('gray_color')
                            ->label('Gray Color')
                            ->default('#b0b0b0')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\ColorPicker::make('success_color')
                            ->label('Success Color')
                            ->default('#28a745')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\ColorPicker::make('warning_color')
                            ->label('Warning Color')
                            ->default('#ffcc00')
                            ->required()
                            ->columnSpan(1),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('domains.domain')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ColorColumn::make('primary_color')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(), 
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\RestoreAction::make(),
                // Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withoutGlobalScopes([
    //             SoftDeletingScope::class,
    //         ]);
    // }
}
