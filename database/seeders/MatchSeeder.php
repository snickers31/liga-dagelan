<?php

namespace Database\Seeders;

use App\Models\MatchClub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            for ($x = 3; $x >= 1; $x--) {
                if ($x == $i) {
                    continue;
                }
                MatchClub::firstOrCreate(["home_club_id" => $i, "away_club_id" => $x], [
                    "home_club_id" => $i,
                    "home_club_goal" => rand(1, 7),
                    "away_club_id" => $x,
                    "away_club_goal" => rand(1, 7)
                ]);
            }
        }
        var_dump("all done");
    }
}
