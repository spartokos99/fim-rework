<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class EditUserProfile extends EditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),

                FileUpload::make('image')
                    ->image()
                    ->imageEditor(2)
                    ->imageAspectRatio('1:1')
                    ->imageEditorAspectRatioOptions([
                        '1:1' => '1:1'
                    ])
                    ->imageEditorEmptyFillColor('#000000')
                    ->automaticallyOpenImageEditorForAspectRatio()
                    ->automaticallyResizeImagesToHeight(500)
                    ->automaticallyResizeImagesToWidth(500)
                    ->automaticallyResizeImagesMode('cover')
                    ->maxSize(40960)
                    ->previewable(true)
                    ->disk('public')
                    ->visibility('public')
                    ->directory('users/avatars'),

                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getCurrentPasswordFormComponent(),
            ]);
    }
}