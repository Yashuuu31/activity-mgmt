<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserActivityService
{
    public function generateActivities(array $userIds = []): void
    {
        $pointArr = [];
        $users = User::select('id');

        if (!empty($userIds)) {
            $users = $users->whereIn('id', $userIds);
        }

        $users = $users->get();
        $activityTypes = config('site.activity.types');
        foreach ($users as $user) {
            $activityCount = rand(1, 3);
            for ($i = 0; $i < $activityCount; $i++) {
                $activityType = $activityTypes[array_rand($activityTypes)];
                $pointArr[] = [
                    'user_id' => $user->id,
                    'points' => config('site.activity.default_points'),
                    'activity' => $activityType,
                    'created_at' => Carbon::now()
                ];
            }
        }

        UserActivity::insert($pointArr);
        User::joinSub(
            UserActivity::select('user_id')
                ->selectRaw('DENSE_RANK() OVER (ORDER BY SUM(points) DESC) AS new_rank')
                ->groupBy('user_id'),
            'ua',
            'users.id',
            '=',
            'ua.user_id'
        )
            ->update([
                'users.rank' => DB::raw('ua.new_rank')
            ]);
    }
}
