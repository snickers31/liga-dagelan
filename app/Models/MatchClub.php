<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchClub extends Model
{
    use HasFactory;

    protected $table = 'tbl_match';

    protected $fillable = ["home_club_id", "home_club_goal", "away_club_id", "away_club_goal"];
}
