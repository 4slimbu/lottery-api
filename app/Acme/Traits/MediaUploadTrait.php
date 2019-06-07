<?php

namespace App\Acme\Traits;

use App\Acme\Models\User;
use Spatie\MediaLibrary\Models\Media;

trait MediaUploadTrait
{
    /**
     * Checks if the provided image string is base64 encoded or not
     *
     * @param $image
     * @return int
     */
    public function isBase64Image($image)
    {
        return preg_match('#^data:image/\w+;base64,#i', $image);
    }

    /**
     * Saves profile picture
     *
     * It saves profile picture in "profile" collection in "profile" filesystem.
     * If profile picture already exists in the collection, then it deletes all of
     * them before saving new one.
     *
     * @param User $user
     * @param $imageFile
     */
    public function saveProfilePicture(User $user, $imageFile)
    {
        try {
            // If profile picture already exist, then delete it.
            if ($user->getFirstMedia('profile')) {
                $user->getFirstMedia('profile')->delete();
            }

            // If base64 image is provided, then use addMediaFromBase64 function
            // to process and save image, else proceed normally
            if ($this->isBase64Image($imageFile)) {
                $user->addMediaFromBase64($imageFile)
                    ->usingFileName(str_random(32) . '.png')
                    ->toMediaCollection('profile', 'profile');
            } else {
                $user->addMedia($imageFile)
                    ->usingFileName(str_random(32) . '.png')
                    ->toMediaCollection('profile', 'profile');
            }
        } catch (\Exception $exception) {
            // fall back silently
        }
    }

    /**
     * Delete media including all versions of it from the filesystem
     *
     * @param $media
     * @return mixed
     */
    public function destroyImage(Media $media)
    {
        return $media->delete();
    }
}