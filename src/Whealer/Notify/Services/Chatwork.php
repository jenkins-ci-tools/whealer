<?php
namespace Whealer\Notify\Services;
use \Whealer\Notify\AbstructService as Service;
use \Whealer\Shell\CommandCreator;
class Chatwork extends Service
{
    CONST ENDPOINT = "https://api.chatwork.com/v1/rooms/%s/messages";

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
        $message = "[info][title]Build: {$result} {$branch}#{$commit_id}@{$commit_auther}[/title]{$commit_url} \n {$commit_comment}[/info]";
        return CommandCreator::get("curl", [
            "-X"=>"POST",
            "-H"=>"\"X-ChatWorkToken: {$arg->api_token}\"",
            "-d"=> "body=\"{$message}\""]
        , sprintf(self::ENDPOINT, $arg->room_id));
    }
}
