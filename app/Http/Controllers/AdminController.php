<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\MatchClub;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function IndexClub()
    {
        $results = DB::select("
            SELECT tbl_klub.nama_klub,
    IFNULL(SUM(main),0) AS main,
    IFNULL(SUM(points),0) AS total_points,
    IFNULL(SUM(goal_masuk),0) AS masuk,
    IFNULL(SUM(kemasukan),0) AS kemasukan,
    IFNULL(SUM(menang),0) AS menang,
    IFNULL(SUM(kalah),0) AS kalah,
    IFNULL(SUM(seri),0) AS seri
FROM (
    SELECT home_club_id AS club_id,
        SUM(CASE WHEN home_club_goal > away_club_goal THEN 3
                    WHEN home_club_goal = away_club_goal THEN 1
                    ELSE 0
            END) AS points,
        COUNT(home_club_id) AS main,
        SUM(CASE WHEN home_club_goal > away_club_goal THEN 1 ELSE 0 END) AS menang,
        SUM(CASE WHEN home_club_goal = away_club_goal THEN 1 ELSE 0 END) AS seri,
        SUM(CASE WHEN home_club_goal < away_club_goal THEN 1 ELSE 0 END) AS kalah,
        SUM(home_club_goal) AS goal_masuk,
        SUM(away_club_goal) AS kemasukan
    FROM tbl_match tm
    GROUP BY home_club_id

    UNION

    SELECT away_club_id AS club_id,
        SUM(CASE WHEN away_club_goal > home_club_goal THEN 3
                    WHEN away_club_goal = home_club_goal THEN 1
                    ELSE 0
            END) AS points,
        COUNT(away_club_id) AS main,
        SUM(CASE WHEN away_club_goal > home_club_goal THEN 1 ELSE 0 END) AS menang,
        SUM(CASE WHEN away_club_goal = home_club_goal THEN 1 ELSE 0 END) AS seri,
        SUM(CASE WHEN away_club_goal < home_club_goal THEN 1 ELSE 0 END) AS kalah,
        SUM(away_club_goal) AS goal_masuk,
        SUM(home_club_goal) AS kemasukan
    FROM tbl_match tm
    GROUP BY away_club_id
) AS club_points
RIGHT JOIN tbl_klub  ON tbl_klub.id = club_points.club_id
GROUP BY club_id,tbl_klub.nama_klub
ORDER BY total_points DESC;
        ");
        return  response()->json($results, 200);
    }

    public function CreateClub(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'bail|required|unique:tbl_klub,nama_klub|max:255',
            'kota' => 'bail|required',
        ]);


        try {
            Klub::create([
                "nama_klub" =>  $request->nama,
                "kota_klub" => $request->kota
            ]);
            return response()->json("Klub baru berhasil ditambahkan", 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function CreateMatch(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                foreach ($request->matchs as $match) {

                    $home = Klub::where("nama_klub", $match['home_club_name'])->first();
                    if (!$home) {
                        throw new Exception("Tim tuan rumah tidak dikenali", 1);
                    }

                    $away = Klub::where("nama_klub", $match['away_club_name'])->first();
                    if (!$away) {
                        throw new Exception("Tim tamu tidak dikenali", 1);
                    }


                    $exist = MatchClub::where('home_club_id', $home->id)->where('away_club_id', $away->id)->first();

                    if ($exist) {
                        throw new Exception("Data pertandingan telah tersedia", 1);
                    }
                    MatchClub::create([
                        "home_club_id" => $home->id,
                        "home_club_goal" => $match['home_club_goals'],
                        "away_club_id" => $away->id,
                        "away_club_goal" => $match['away_club_goals']
                    ]);
                }
            });
            return response()->json("Data pertandingan berhasil ditambahkan", 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
