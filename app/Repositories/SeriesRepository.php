<?php

namespace App\Repositories;

use App\Series;

class SeriesRepository
{
    //$year_season = $v['season_year'] + $this->season_calculator($v['season_name']);
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

    function create_or_update($series_data) {
        $series = App\Series::find($series_data['mal_id']);

        $year_season = $series_data['year'] + $this->season_calculator($series_data['season']);

        if ($series) {
            $series->title1      = $series_data['title'];
            $series->type        = $series_data['type'];
            $series->episodes    = $series_data['episodes'];
            $series->season      = $series_data['season'];
            $series->year        = $series_data['year'];
            $series->year_season = $year_season;

            $series->save();
        } else {
            $new_series = new Series;

            $new_series->mal_id      = $series_data['mal_id'];
            $new_series->title1      = $series_data['title'];
            $new_series->type        = $series_data['type'];
            $new_series->episodes    = $series_data['episodes'];
            $new_series->season      = $series_data['season'];
            $new_series->year        = $series_data['year'];
            $new_series->year_season = $year_season;

            $new_series->save();
        }
    }
}