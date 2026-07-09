<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateIdea
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(array $attributes): void
    {
        $data = collect($attributes)->only([
            'title', 'description', 'status', 'links',
        ])->toArray();

        if (($attributes['image'] ?? null) instanceof UploadedFile) {
            $data['image_path'] = $attributes['image']->store('ideas', 'public');
        }

        // Solution for testing form without (enctype="multipart/form-data) issues.
        // This converts the Base64 image to a Binary Image.
        /*
        if ($image = ($attributes['image'] ?? null)) {
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $data['image_path'] = $image->store('ideas', 'public');
            } elseif (is_string($image) && str_starts_with($image, 'data:image')) {
                // Convert Base64 to Binary Image
                @list($type, $fileData) = explode(';', $image);
                @list(, $fileData)      = explode(',', $fileData);
                @list(, $extension)     = explode('/', $type);

                $binaryData = base64_decode($fileData);
                $path = 'ideas/' . Str::random(40) . '.' . $extension;

                Storage::disk('public')->put($path, $binaryData);
                $data['image_path'] = $path;
            }
        }*/

        DB::transaction(function () use ($data, $attributes) {
            $idea = $this->user->ideas()->create($data);

            $idea->steps()->createMany($attributes['steps'] ?? []);
        });
    }
}
