<?php

namespace App\Service;

use App\Entity\Post;

/**
 * Class StatService.
 */
class PostStatService
{
    /**
     * Calculate average character length of posts per month.
     *
     * @param Post[] $posts
     *
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
     * Find longest post by character length per month.
     *
     * @param Post[] $posts
     *
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
     * Calculate total posts split by week number.
     *
     * @param Post[] $posts
     *
     * @return array
     */
    public function totalPostsByWeekNumber($posts)
    {
        $weeks = [];
        foreach ($posts as $post) {
            $week = $post->getWeek();
            $weeks[$week] ??= 0;
            ++$weeks[$week];
        }

        return $weeks;
    }

    /**
     * Calculate average number of posts per user per month.
     *
     * @param Post[] $posts
     *
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
            ++$usersMonths[$userId][$month];
        }

        $result = [];
        foreach ($users as $userId => $userName) {
            $average = round(array_sum($usersMonths[$userId]) / count($usersMonths[$userId]), 2);
            $result[] = [
                'User Id' => $userId,
                'User Name' => $userName,
                'Average Posts Per Month' => $average,
            ];
        }

        return $result;
    }
}
