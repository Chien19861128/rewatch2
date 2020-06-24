<?php
namespace App\Repositories;

use App\UserList;

class UserListRepository
{
    function create_or_update($userlist_data) {

        $userlist = UserList::where('mal_user_id', $userlist_data['mal_user_id'])
            ->where('mal_series_id', $userlist_data['mal_series_id'])
            ->first();

        if ($userlist) {
            UserList::where('mal_user_id', $userlist_data['mal_user_id'])
                ->where('mal_series_id', $userlist_data['mal_series_id'])
                ->update(['status' => $this->status_code($userlist_data['status']),'weighted_score' => $userlist_data['weighted_score']]);

        } else {
            $new_userlist = new UserList;

            $new_userlist->mal_user_id    = $userlist_data['mal_user_id'];
            $new_userlist->mal_series_id  = $userlist_data['mal_series_id'];
            $new_userlist->status         = $this->status_code($userlist_data['status']);
            $new_userlist->weighted_score = $userlist_data['weighted_score'];

            $new_userlist->save();
        }
    }


    function status_code($status) {
        switch($status) {
            case 'ptw':
                return 0;
                exit;
            case 'watching':
                return 1;
                exit;
        }
    }
}