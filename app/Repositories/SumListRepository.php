<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\SumList;

class SumListRepository
{
    function create_or_update($sumlist_data) {
        $sumlist = App\SumList::find($sumlist_data['mal_series_id']);

        if ($sumlist) {
            if ($sumlist_data['status'] == 'ptw') {
                $sumlist->total_ptw          = 1;
                $sumlist->weighted_ptw_score = $sumlist_data['weighted_score'];
            } else if ($sumlist_data['status'] == 'watching') {
                $sumlist->total_watching          = 1;
                $sumlist->weighted_watching_score = $sumlist_data['weighted_score'];
            }

            $sumlist->save();
        } else {
            $new_sumlist = new SumList;

            $new_sumlist->mal_series_id = $sumlist_data['mal_user_id'];
            if ($sumlist_data['status'] == 'ptw') {
                $new_sumlist->total_ptw          += 1;
                $new_sumlist->weighted_ptw_score += $sumlist_data['weighted_score'];
            } else if ($sumlist_data['status'] == 'watching') {
                $new_sumlist->total_watching          += 1;
                $new_sumlist->weighted_watching_score += $sumlist_data['weighted_score'];
            }

            $new_sumlist->save();
        }
    }

    public function list(){

        return DB::select('
            SELECT sum_lists.*, series.title1, series.type, series.year, series.season FROM sum_lists 
            JOIN series ON sum_lists.mal_series_id = series.mal_id
            ORDER BY (sum_lists.weighted_ptw_score + sum_lists.weighted_watching_score) DESC
            LIMIT :limit OFFSET :offset
            ', ['limit' => 200, 'offset' => 0]);
    }

}