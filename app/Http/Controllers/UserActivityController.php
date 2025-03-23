<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs;
use App\Traits\ApiResponser;

class UserActivityController extends Controller
{
    use ApiResponser;

    public function generateActivity()
    {
        Jobs\User\GenerateActivity::dispatch();

        $data['success'] = true;
        $data['message'] = __('message.activityGenerateSuccess');
        return $this->apiSuccess($data);
    }
}
