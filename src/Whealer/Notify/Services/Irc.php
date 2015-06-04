<?php
namespace Whealer\Notify\Services;
use \Whealer\Notify\AbstructService as Service;

class Irc extends Service
{
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
        $arg = $this->arg;
        $result = ($status) ? "PASSED" : "FAILED";

        switch(true) {
            case strpos($repository_url, "github.com") !== false:
                $commit_url = "{$repository_url}/commit/{$commit_id}"; break;
            case strpos($repository_url, "bitbucket.org") !== false:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
            default:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
        }
        $message = "Build: {$result} {$branch}#{$commit_id} {$commit_url} @{$commit_auther}\n{$commit_comment}";

        return CommandCreator::get("curl", ["-F channel={$arg->room_id}" , "-F message='{$message}'"], $arg->end_point);
    }
}
