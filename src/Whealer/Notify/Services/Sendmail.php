<?php
namespace Whealer\Notify\Services;
use \Whealer\Notify\AbstructService as Service;
use \Whealer\Shell\CommandCreator;

class Sendmail extends Service
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
        $command = "";

        $result = ($status) ? "PASSED" : "FAILED";
        $resulthtml = ($status) ? "<span style='font-weight:bold;color:#CFCFCF;background:#00FF00;'>{$result}</span>": "<span style='font-weight:bold;color:#CFCFCF;background:#FF0000'>{$result}</span>";
        switch(true) {
            case strpos($repository_url, "github.com") !== false:
                $commit_url = "{$repository_url}/commit/{$commit_id}"; break;
            case strpos($repository_url, "bitbucket.org") !== false:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
            default:
                $commit_url = "{$repository_url}/commits/{$commit_id}"; break;
        }
        $toAddr  = str_replace(" ", "", $arg->end_point);
        $subject = "Build: {$result} {$branch}#{$commit_id}";

        $command .= "From: {$arg->user_name}\n";
        $command .= "To: {$toAddr}\n";
        $command .= "Subject: {$subject}\n";
        $command .= "Content-Type: text/html; charset=UTF-8\n";
        $command .= "Content-Transfer-Encoding: 8bit\n";
        $command .= "MIME-Version: 1.0\n";
        $command .= "\n";
        $command .= "Build:  {$resulthtml}<br >";
        $command .= "branch: {$branch}<br >";
        $command .= "commit: <a href='{$commit_url}'>{$commit_id}</a><br >";
        $command .= "auther: {$commit_auther}<br ><br >";
        $command .= "message:<br>{$commit_comment}<br >";
        $sendmail = CommandCreator::which("sendmail");
        return CommandCreator::get("cat <<EOM | $sendmail", ["-t -i"], $command);
    }
}
