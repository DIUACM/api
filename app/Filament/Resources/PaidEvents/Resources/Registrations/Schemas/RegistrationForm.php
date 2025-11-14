<?php

namespace App\Filament\Resources\PaidEvents\Resources\Registrations\Schemas;

use App\Enums\Gender;
use App\Enums\PaymentMethod;
use App\Enums\RegistrationStatus;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registrant')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->nullable()
                                    ->helperText('Associate an existing user (optional)'),
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Grid::make()
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(32),
                            ]),

                        Grid::make()
                            ->schema([
                                TextInput::make('student_id')
                                    ->label('Student ID')
                                    ->maxLength(64),
                                TextInput::make('department')
                                    ->maxLength(255),
                                TextInput::make('section')
                                    ->maxLength(64),
                            ]),

                        Grid::make()
                            ->schema([
                                TextInput::make('lab_teacher_name')
                                    ->label('Lab Teacher Name')
                                    ->maxLength(255),
                                Select::make('tshirt_size')
                                    ->options([
                                        'XS' => 'XS',
                                        'S' => 'S',
                                        'M' => 'M',
                                        'L' => 'L',
                                        'XL' => 'XL',
                                    ])
                                    ->nullable(),
                                Select::make('gender')
                                    ->options(Gender::class)
                                    ->nullable(),
                            ]),

                        Grid::make()
                            ->schema([
                                TextInput::make('amount')
                                    ->label('Amount')
                                    ->numeric()
                                    ->step('0.01')
                                    ->prefix('৳')
                                    ->nullable(),
                                Select::make('payment_method')
                                    ->options(PaymentMethod::class)
                                    ->nullable(),
                                Checkbox::make('transport_service_required')
                                    ->label('Transport required'),
                            ]),

                        TextInput::make('pickup_point')
                            ->maxLength(255)
                            ->nullable()
                            ->helperText('Optional pickup point'),

                        Grid::make()
                            ->schema([
                                Select::make('status')
                                    ->options(RegistrationStatus::class)
                                    ->required(),
                            ]),
                    ]),

                Section::make('Metadata')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime('M j, Y g:i A', timezone: 'Asia/Dhaka'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('M j, Y g:i A', timezone: 'Asia/Dhaka'),
                            ]),
                    ])
                    ->collapsed()
                    ->hiddenOn('create'),
            ]);
    }
}
