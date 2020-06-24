<?php
namespace App\Services;
use App\Repositories\UserRepository;
use App\Repositories\SeriesRepository;
use App\Repositories\UserListRepository;
use App\Repositories\SumListRepository;

class UserListService
{
    protected $User, $Series, $UserList, $SumList;

    public function __construct(
        UserRepository $User,
        SeriesRepository $Series,
        UserListRepository $UserList,
        SumListRepository $SumList
    ) {
        $this->User = $User;
        $this->Series = $Series;
        $this->UserList = $UserList;
        $this->SumList = $SumList;
    }
    
    public function sync_all_user_lists() {
        $active_users = $this->User->get_active_users_from_ral();
        
        foreach ($active_users as $k => $v) {
            $user_ptw = $this->User->get_user_mal($v['mal_user_id'], 'ptw');
            $this->update_lists($v['mal_user_id'], 'ptw', $user_ptw);

            $user_watching = $this->User->get_user_mal($v['mal_user_id'], 'watching');
            $this->update_lists($v['mal_user_id'], 'watching', $user_watching);
        }
    }

    function update_lists ($mal_user_id, $status, $user_list) {
        if (isset($user_list['anime'])) {
            foreach ($user_list['anime'] as $k => $v) {;
                $this->Series->create_or_update($v);

                $list_data = array(
                    'mal_user_id'    => $mal_user_id,
                    'mal_series_id'  => $v['mal_series_id'],
                    'status'         => $status,
                    'weighted_score' => $user_list['weight'],
                );
                $this->UserList->create_or_update($list_data);
                $this->SumList->create_or_update($list_data);
            }
        }
        sleep(2);
    }
}