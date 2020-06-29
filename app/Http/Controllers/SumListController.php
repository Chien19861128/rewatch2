<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\SumListService;

class SumListController extends BaseController
{
    use ValidatesRequests;

    protected $SumList;
    public function __construct(
        SumListService $SumList
    ){
        $this->SumList=$SumList;
    }

    public function get_list() {
        $this->SumList->get_list();
    }
}
