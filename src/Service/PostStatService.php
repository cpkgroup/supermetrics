<?php

namespace App\Service;

use App\Entity\Post;

/**
 *
 * Class StatService
 * @package App\Service
 */
class PostStatService
{
    /**
     *
     * @param Post[] $posts
     * @return array
     */
    public function averageLengthOfPostsPerMonth($posts)
    {
        $months = [];
        foreach ($posts as $post) {
            $month = $post->getMonth();
            $months[$month][] = $post->getMessageLength();
        }

        return array_map(function ($data) {
            return round(array_sum($data) / count($data));
        }, $months);
    }

    /**
     *
     * @param Post[] $posts
     * @return array
     */
    public function longestPostLengthPerMonth($posts)
    {
        $months = [];
        foreach ($posts as $post) {
            $month = $post->getMonth();
            $months[$month][] = $post->getMessageLength();
        }

        return array_map(function ($data) {
            return max($data);
        }, $months);
    }

    /**
     *
     * @param Post[] $posts
     * @return array
     */
    public function totalPostsByWeekNumber($posts)
    {
        $weeks = [];
        foreach ($posts as $post) {
            $week = $post->getWeek();
            $weeks[$week] ??= 0;
            $weeks[$week]++;
        }

        return $weeks;
    }

    /**
     *
     * @param Post[] $posts
     * @return array
     */
    public function averageNumberOfPostsPerUserPerMonth($posts)
    {
        $users = [];
        $usersMonths = [];
        foreach ($posts as $post) {
            $userId = $post->getUserId();
            $month = $post->getMonth();
            $users[$userId] = $post->getFromName();
            $usersMonths[$userId][$month] ??= 0;
            $usersMonths[$userId][$month]++;
        }

        $result = [];
        foreach ($users as $userId => $userName) {
            $average = round(array_sum($usersMonths[$userId]) / count($usersMonths[$userId]), 2);
            $result[] = [
                'User Id' => $userId,
                'User Name' => $userName,
                'Average Posts Per Month' => $average
            ];
        }

        return $result;
    }
}
