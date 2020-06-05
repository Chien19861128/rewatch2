<?php
namespace App\Repositories;

use App\User;

class UserRepository
{
    public function get_active_users_from_ral() {
        $html = file_get_contents('http://www.redditanimelist.net/users.php?time=Week');

        $array = $this->html_to_obj($html);
        $users = array();

        foreach ($array['children'][1]['children'][0]['children'][5]['children'] as $k => $v) {
            if ($k == 0) continue;

            $mal_id      = $v['children'][1]['children'][0]['html'];
            $reddit_id   = $v['children'][2]['children'][0]['html'];
            $update_time = $v['children'][3]['html'];

            $user_data = array(
                'mal_id'      => $mal_id,
                'reddit_id'   => $reddit_id,
                'update_time' => $update_time
            );

            $users[] = $user_data;

            $this->create_or_update($user_data);
        }
        unset($array);
        
        return $users;
    }
    
    public function get_user_mal($mal_id, $list = 'ptw') {
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
            $userlist_data['anime'][] = array(
                'mal_id'      => $v['mal_id'],
                'title'       => $v['title'],
                'type'        => $v['type'],
                'episodes'    => $v['total_episodes'],
                'season'      => $v['season_name'],
                'year'        => $v['season_year']
            );
        }
        
        return $userlist_data;
    }

    public function create_or_update($user_data) {
        $user = App\User::where('name', $user_data['reddit_id'])->first();

        if ($user) {
            if ($user->mal_id != $user_data['mal_id']) {
                $user->mal_id = $user_data['mal_id'];

                $user->save();
            }
        } else {
            $new_user = new User;

            $new_user->mal_id    = $user_data['mal_id'];
            $new_user->reddit_id = $user_data['reddit_id'];

            $new_user->save();
        }
    }

    function html_to_obj($html) {
        //$html = htmlentities($html);
        //$html = html_entity_decode($html);

        $html = str_replace("&", "&amp;", $html);


        //print_r($html);die;
        //$html = $html->getElementsByTagName('body');
        $dom = new \DOMDocument();
        //$dom->strictErrorChecking = false;

        // set error level
        //$internalErrors = libxml_use_internal_errors(true);

        $dom->loadHTML($html);

        //$body = $dom->getElementsByTagName('body');

        //$dom->loadHTML($html);

        // Restore error level
        //libxml_use_internal_errors($internalErrors);

        print_r($dom->documentElement);die;
        return $this->element_to_obj($dom->documentElement);
    }
    
    function element_to_obj($element) {
        //$obj = array( "tag" => $element->tagName );
        $obj = array();
        foreach ($element->attributes as $attribute) {
            $obj[$attribute->name] = $attribute->value;
        }
        foreach ($element->childNodes as $subElement) {
            if ($subElement->nodeType == XML_TEXT_NODE) {
                $obj["html"] = $subElement->wholeText;
            } else {
                $obj["children"][] = $this->element_to_obj($subElement);
            }
        }
        print_r($obj);die;
        return $obj;
    }
}