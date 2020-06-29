<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\UserListService;

class JikanController extends BaseController
{
    use ValidatesRequests;

    protected $UserList;
    public function __construct(
        UserListService $UserList
    ){
        $this->UserList=$UserList;
    }

    public function update_lists() {
        set_time_limit(0);

        $this->UserList->sync_all_user_lists();
    }
}
