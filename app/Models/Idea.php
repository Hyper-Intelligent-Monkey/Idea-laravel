<?php

declare(strict_types=1);

namespace App\Models;

use App\IdeaStatus;
use Database\Factories\IdeaFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Idea extends Model
{
    /** @use HasFactory<IdeaFactory> */
    use HasFactory;

    protected $casts = [
        'links' => AsArrayObject::class,
        'status' => IdeaStatus::class,
    ];

    public static function statusCounter(User $user): Collection
    {
        $counts = $user->ideas()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return collect(IdeaStatus::cases())
            ->mapWithKeys(fn ($status) => [
                $status->value => $counts->get($status->value, 0),
            ])->put('all', $counts->sum());
    }

    protected $attributes = [
        'status' => IdeaStatus::PENDING->value,
        'links' => '[]',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function formattedDescription() : Attribute
    {
        return Attribute::get(fn($value, $attributes) => str($attributes['description'])->markdown());
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => htmlspecialchars_decode((string) $value),
        );
    }
}
