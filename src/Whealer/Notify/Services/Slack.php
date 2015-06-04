<?php
namespace Whealer\Notify\Services;
use \Whealer\Notify\AbstructService as Service;
use \Whealer\Shell\CommandCreator;

class Slack extends Service
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
        $green = (isset($_ENV['EMOJI_GREEN'])) ? $_ENV['EMOJI_GREEN'] : ":sunny:";
        $red   = (isset($_ENV['EMOJI_RED']))   ? $_ENV['EMOJI_RED']   : ":umbrella:";

        $result = ($status) ? "PASSED" : "FAILED";

        switch(true) {
            case strpos($repository_url, "github.com") !== false:
                $commit_url = "{$repository_url}/commit/{$commit_id}"; break;
            case strpos($repository_url, "bitbucket.org") !== false:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
            default:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
        }

        $message = "Build: {$result} <{$commit_url}|{$branch}#{$commit_id}> @{$commit_auther}\n{$commit_comment}";

        $payload_obj = (object)array(
            "channel"    => "#".ltrim($arg->room_id, "#"),
            "username"   => $arg->user_name,
            "icon_emoji" => ($status) ? $green : $red,
            "text"       => $message
        );
        $payload = json_encode($payload_obj, JSON_UNESCAPED_UNICODE);
        return CommandCreator::get("curl", ["--data", "payload='{$payload}'"], $arg->end_point);
    }
}
