<?php
namespace Whealer\Notify\Services;
use \Whealer\Notify\AbstructService as Service;
use \Whealer\Shell\CommandCreator;
/**
 * curl --data-urlencode 'source=#{source}' -d format=html
 */
class Idobata extends Service
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
        $class  = ($status) ? "success" : "failed";
        $arg = $this->arg;
        switch(true) {
            case strpos($repository_url, "github.com") !== false:
                $commit_url = "{$repository_url}/commit/{$commit_id}"; break;
            case strpos($repository_url, "bitbucket.org") !== false:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
            default:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
        }
        $message  = "<p><span class=\"label label-{$class}\">Build: {$result}</span></p>";
        $message .= "<ul><li>commited by ${commit_auther} <a href='{$commit_url}'>{$branch} #{$commit_id}</a></li></ul>";
        $message .= "<pre>{$commit_comment}</pre>";
        return CommandCreator::get("curl",["-d"=>"format=html","--data-urlencode"=> "source='{$message}'"], $arg->end_point);
    }
}
