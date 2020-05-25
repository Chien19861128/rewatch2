<?php
namespace App\Services;
use App\Repositories\UserRepository;

class UserServices
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    
    public function sync_users() {
        $active_users = $this->user->get_active_users_from_ral();
        
        foreach ($active_users as $k => $v) {
            
        }
    }
}