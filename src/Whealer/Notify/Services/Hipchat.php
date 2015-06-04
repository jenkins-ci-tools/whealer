<?php
namespace Whealer\Notify\Services;
use \Whealer\Notify\AbstructService as Service;
use \Whealer\Shell\CommandCreator;
class Hipchat extends Service
{
    CONST ENDPOINT = "https://api.hipchat.com/v1/rooms/message?auth_token=%s&format=json";

    /**
     * @var boolean $status
     * @var string  $commit_id
     * @var string  $commit_auther
     * @var string  $commit_comment
     * @var string  $branch
     * @var string  $repository_url
     */
    public function get($status, $commit_id, $commit_auther, $commit_comment, $branch, $repository_url)
    {
        $color  = ($status) ? "GREEN" : "RED";
        $result = ($status) ? "PASSED" : "FAILED";
        switch(true) {
            case strpos($repository_url, "github.com") !== false:
                $commit_url = "{$repository_url}/commit/{$commit_id}"; break;
            case strpos($repository_url, "bitbucket.org") !== false:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
            default:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
        }
        $arg = $this->arg;
        $paramater = sprintf('"room_id=%s&from=%s&color=%s&notify=1"', $arg->room_id, $arg->user_name, $color);
        $message = "\"Build: {$result}! \n<a href='{$commit_url}'>{$branch} #{$commit_id}@{$commit_auther}</a>\"";
        return CommandCreator::get("curl",["-d"=>$paramater, "--data-urlencode"=> "message={$message}"], sprintf(self::ENDPOINT, $arg->api_token));
    }
}
