<?php
namespace Whealer\Test\Notify;
use Whealer\Notify\Services\Slack;

class SlackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function get()
    {
        $argument = [
            "API_TOKEN" => "",
            "USER_NAME" => "Jenkins",
            "ROOM_ID"   => "general",
            "END_POINT" => " https://hooks.slack.com/services/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"
        ];
        $commit_id = "4a516a46292655c1c2b15ff6f67897a5333a8171";
        $commit_auther = "aozora0000";
        $commit_comment = "fixed .jenkins.yml";
        $branch = "master";
        $repository_url = "https://github.com/Duckpeller/Duckpeller";
        $idobata = Slack::getInstance($argument);
        $result = $idobata->get(true, $commit_id, $commit_auther, $commit_comment, $branch, $repository_url);
        $this->assertEquals('curl --data payload=\'{"channel":"#general","username":"Jenkins","icon_emoji":":sunny:","text":"Build: PASSED <https:\/\/github.com\/Duckpeller\/Duckpeller\/commit\/4a516a46292655c1c2b15ff6f67897a5333a8171|master#4a516a46292655c1c2b15ff6f67897a5333a8171> @aozora0000\nfixed .jenkins.yml"}\'  https://hooks.slack.com/services/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',$result);
    }
}
