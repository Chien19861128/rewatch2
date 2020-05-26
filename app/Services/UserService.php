<?php
namespace App\Services;
use App\Repositories\UserRepository;
use App\Repositories\SeriesRepository;
use App\Repositories\UserListRepository;
use App\Repositories\SumListRepository;

class UserServices
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
    
    public function sync_users() {
        $active_users = $this->User->get_active_users_from_ral();
        
        foreach ($active_users as $k => $v) {
            $user_ptw = $this->User->get_user_mal($v['mal_id'], 'ptw');

            sleep(2);

            $user_watching = $this->User->get_user_mal($v['mal_id'], 'watching');
            sleep(2);
        }
    }
}