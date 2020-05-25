<?php
namespace App\Repositories;

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

            $users[] = array(
                'mal_id'      => $mal_id,
                'reddit_id'   => $reddit_id,
                'update_time' => $update_time
            );

            $this->update_user_by_mal_id($mal_id);
        }
        unset($array);
        
        return $users;
    }
    
    public function get_user_mal($mal_id, $list = 'ptw') {
        $user_ptw = json_decode(file_get_contents("https://api.jikan.moe/v3/user/{$mal_id}/animelist/{$list}"), true);

        $user_ptw_count = count($user_ptw['anime']);

        if ($user_ptw_count >= 500) {
            return 0;
        } else if ($user_ptw_count >= 50) {
            $weight = 50/$user_ptw_count;
        } else {
            $weight = 1;
        }

        $user_data = array();
        $user_data['weight'] = $weight;

        foreach ($user_ptw['anime'] as $k => $v) {
            $user_data['anime'][] = array(
                'mal_id'      => $v['mal_id'],
                'title'       => $v['title'],
                'type'        => $v['type'],
                'episodes'    => $v['total_episodes'],
                'season'      => $v['season_name'],
                'year'        => $v['season_year']
            );
        }
        
        return $user_data;
    }
    
    function html_to_obj($html) {
        $dom = new DOMDocument();
        $dom->loadHTML($html);
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
        return $obj;
    }
}