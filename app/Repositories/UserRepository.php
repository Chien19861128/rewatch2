<?php
namespace App\Repositories;

use App\User;
use voku\helper\HtmlDomParser;

class UserRepository
{
    public function get_active_users_from_ral() {

        $html = HtmlDomParser::file_get_html('http://www.redditanimelist.net/users.php?time=Week');

        $table = $html->find('.users');

        // initialize empty array to store the data array from each row
        $users = array();

        // loop over rows
        foreach($table->find('tr') as $row) {

            // initialize array to store the cell data from each row
            $rowData = array();
            foreach($row->find('td') as $cell) {
                $inner_text = '';
                // push the cell's text to the array
                foreach($cell->find('a') as $cell2) {
                    $inner_text = $cell2->innertext;
                }
                $rowData[] = (!empty($inner_text)) ? $inner_text : $cell->innertext;
            }

            // push the row's data array to the 'big' array

            if (count($rowData) == 4) {

                $user_data = array(
                    'mal_user_id' => $rowData[2],
                    'reddit_id'     => $rowData[1],
                    'update_time'   => $rowData[3]
                );

                $this->create_or_update($user_data);

                $users[] = $user_data;
            }
        }

        return $users;
    }
    
    public function get_user_mal($mal_id, $list = 'ptw') {
        try {
            $userlist = json_decode(file_get_contents("https://api.jikan.moe/v3/user/{$mal_id}/animelist/{$list}"), true);

            $userlist_count = count($userlist['anime']);

            if ($userlist_count >= 500) {
                return 0;
            } else if ($userlist_count >= 50) {
                $weight = 50/$userlist_count;
            } else {
                $weight = 1;
            }

            $userlist_data = array();
            $userlist_data['weight'] = $weight;

            foreach ($userlist['anime'] as $k => $v) {
                $start_date = strtotime($v['start_date']);
                $season_name = ($v['season_name'])?$v['season_name']:$this->get_season(date('n', $start_date));
                $season_year = ($v['season_year'])?$v['season_year']:date('Y', $start_date);

                $userlist_data['anime'][] = array(
                    'mal_series_id' => $v['mal_id'],
                    'title'         => $v['title'],
                    'type'          => $v['type'],
                    'episodes'      => $v['total_episodes'],
                    'season'        => $season_name,
                    'year'          => $season_year
                );
            }

            return $userlist_data;
        } catch (\Exception $e) {

            return false;
        }
    }

    public function create_or_update($user_data) {
        $user = User::where('name', $user_data['reddit_id'])->first();

        if ($user) {
            if ($user->mal_user_id != $user_data['mal_user_id']) {
                $user->mal_user_id = $user_data['mal_user_id'];

                $user->save();
            }
        } else {
            $new_user = new User;

            $new_user->mal_user_id = $user_data['mal_user_id'];
            $new_user->name        = $user_data['reddit_id'];

            $new_user->save();
        }
    }

    function get_season($month) {
        if (in_array($month, array(12, 1, 2))) {
            return 'Winter';
        } else if (in_array($month, array(3, 4, 5))) {
            return 'Spring';
        } else if (in_array($month, array(6, 7, 8))) {
            return 'Summer';
        } else {
            return 'Fall';
        }
    }
}