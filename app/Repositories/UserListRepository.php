<?php
namespace App\Repositories;

use App\UserList;

class UserListRepository
{
    function create_or_update($userlist_data) {
        $userlist = App\UserList::where('mal_user_id', $userlist_data['mal_user_id'])
            ->where('mal_series_id', $userlist_data['mal_series_id'])
            ->first();

        if ($userlist) {
            $userlist->status         = $userlist_data['status'];
            $userlist->weighted_score = $userlist_data['weighted_score'];

            $userlist->save();
        } else {
            $new_userlist = new UserList;

            $new_userlist->mal_user_id    = $userlist_data['mal_user_id'];
            $new_userlist->mal_series_id  = $userlist_data['mal_series_id'];
            $new_userlist->status         = $userlist_data['status'];
            $new_userlist->weighted_score = $userlist_data['weighted_score'];

            $new_userlist->save();
        }
    }


}