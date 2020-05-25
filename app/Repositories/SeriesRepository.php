<?php

namespace App\Repositories;

class SeriesRepository
{
    $year_season = $v['season_year'] + $this->season_calculator($v['season_name']);
    function season_calculator($season_name) {
        if ($season_name == 'Winter') {
            return 0;
        } else if ($season_name == 'Spring') {
            return 0.25;
        } else if ($season_name == 'Summer') {
            return 0.5;
        } else if ($season_name == 'Fall') {
            return 0.75;
        }
    }
}