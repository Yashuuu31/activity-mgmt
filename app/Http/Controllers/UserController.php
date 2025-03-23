<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ApiResponser;

    public function index()
    {
        if (request()->ajax()) {
            return $this->getUserList();
        }
        return view('user.index');
    }

    public function getUserList()
    {
        $request = request();
        $userId = (int) $request->user_id;
        $hasFilter = $userId ? true : false;
        $dateRange = $this->getFilterDate();


        $userPointQry = UserActivity::selectRaw('SUM(`points`)')
            ->whereColumn('user_activities.user_id', 'users.id');

        $users = User::query();

        if (!empty($dateRange->start_at) && !empty($dateRange->end_at)) {
            $userPointQry = $userPointQry->whereDate('created_at', '>=', $dateRange->start_at)
                ->whereDate('created_at', '<=', $dateRange->end_at);
            $users = $users->whereHas('activities', function ($subQry) use ($dateRange) {
                $subQry->whereDate('created_at', '>=', $dateRange->start_at)
                    ->whereDate('created_at', '<=', $dateRange->end_at);
            });
        }

        $users = $users->addSelect([
            'total_points' => $userPointQry,
            'priority' => DB::raw("CASE WHEN `users`.`id` = {$userId} THEN 1 ELSE 0 END AS `has_filter`")
        ])
            ->orderBy('has_filter', 'DESC')
            ->orderBy('total_points', 'DESC')
            ->get();

        $viewRender = view('user.ajax-list', [
            'users' => $users,
            'hasFilter' => $hasFilter
        ])->render();

        $data['data'] = $viewRender;
        return $this->apiSuccess($data);
    }

    /**
     * Class's private methods
     */
    private function getFilterDate()
    {
        $request = request();
        $startAt = null;
        $endAt = null;
        if ($request->date_filter == "TODAY") {
            $startAt = Carbon::now()->startOfDay();
            $endAt = Carbon::now()->endOfDay();
        } else if ($request->date_filter == "THIS_MONTH") {
            $startAt = Carbon::now()->startOfMonth();
            $endAt = Carbon::now()->endOfMonth();
        } else if ($request->date_filter == "THIS_YEAR") {
            $startAt = Carbon::now()->startOfYear();
            $endAt = Carbon::now()->endOfYear();
        }


        return (object) [
            'start_at' => $startAt?->format('Y-m-d'),
            'end_at' => $endAt?->format('Y-m-d')
        ];
    }
}
