<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Store extends Model
{
    use HasFactory, Sortable;

    //ソート可能な列を定義する
    public $sortable = ['name', 'updated_at', 'reviews_avg_rating'];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    //平均レビュー評価を計算(なくてもいいかも)
    public function getAverageReviewAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
