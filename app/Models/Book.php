<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "author",
        "created_at",
        "updated_at"
    ];
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function scopeWithAvgRating(Builder $query): Builder|QueryBuilder
    {
        return $query->withAvg('reviews', 'rating');
    }
    public function scopewithReviewsCount(Builder $query): Builder|QueryBuilder
    {
        return $query->withCount('reviews');
    }
    public function scopeReviewsCount(Builder $q): Builder|QueryBuilder
    {
        return $q->withCount('reviews');
    }
    public function scopeTitle(Builder $query, string $title): Builder|QueryBuilder
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }
    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            'reviews' =>
                fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)


        ])->orderBy('reviews_count', 'desc');
    }
    public function scopeMinReviews(Builder $q, int $minReviews)
    {
        return $q->having('reviews_count', '>=', $minReviews);
    }
    public function scopeHighestRated(Builder $query): Builder|QueryBuilder
    {
        return $query->withAvg('reviews', 'rating');
    }
    private function dateRangeFilter(Builder $q, $from = null, $to = null)
    {
        if ($from && !$to) {
            $q->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $q->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $q->whereBetween('created_at', [$from, $to]);
        }
    }
    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())->highestRated(now()->subMonth(), now())->minReviews(2);
    }
    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonths(6), now())->highestRated(now()->subMonths(6), now())->minReviews(5);
    }
    public function scopeHighesRatedtLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(), now())->popular(now()->subMonth(), now())->minReviews(2);
    }
    public function scopeHighestRatedLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonths(6), now())->popular(now()->subMonths(6), now())->minReviews(5);
    }


}
