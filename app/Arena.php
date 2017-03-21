<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arena extends Model
{
    public function participants()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    public function isSubscribed($userId)
    {
        return $this->participants->contains($userId);
    }

    public function getCost()
    {
        return 100;
    }
}
