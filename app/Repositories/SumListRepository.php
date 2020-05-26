<?php
namespace App\Repositories;

use App\SumList;

class SumListRepository
{
    function create_or_update($sumlist_data) {
        $sumlist = App\SumList::find($sumlist_data['mal_series_id']);

        if ($sumlist) {
            if () {

            }
            $sumlist->status         = $sumlist_data['status'];
            $sumlist->weighted_score = $sumlist_data['weighted_score'];

            $sumlist->save();
        } else {
            $new_sumlist = new SumList;

            $new_sumlist->total_watching          = $sumlist_data['mal_user_id'];
            $new_sumlist->total_ptw               = $sumlist_data['mal_series_id'];
            $new_sumlist->weighted_watching_score = $sumlist_data['status'];
            $new_sumlist->weighted_ptw_score      = $sumlist_data['weighted_score'];

            $new_sumlist->save();
        }
    }


}