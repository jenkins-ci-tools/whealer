<?php
namespace Whealer\Test\Notify;
use Whealer\Notify\Services\Chatwork;

class ChatworkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function get()
    {
        $argument = [
            "API_TOKEN" => "2a3da88b47e79b5fa5022c9ae4e6dd83",
            "USER_NAME" => "",
            "ROOM_ID"   => "18624920",
            "END_POINT"  => ""
        ];
        $commit_id = "4a516a46292655c1c2b15ff6f67897a5333a8171";
        $commit_auther = "aozora0000";
        $commit_comment = "fixed .jenkins.yml";
        $branch = "master";
        $repository_url = "https://github.com/Duckpeller/Duckpeller";
        $hipchat = Chatwork::getInstance($argument);

        $result = $hipchat->get(true, $commit_id, $commit_auther, $commit_comment, $branch, $repository_url);
        $this->assertEquals("curl -X POST -H \"X-ChatWorkToken: 2a3da88b47e79b5fa5022c9ae4e6dd83\" -d body=\"[info][title]Build: PASSED #4a516a46292655c1c2b15ff6f67897a5333a8171@aozora0000[/title]https://github.com/Duckpeller/Duckpeller/commit/4a516a46292655c1c2b15ff6f67897a5333a8171 \n fixed .jenkins.yml[/info]\" https://api.chatwork.com/v1/rooms/18624920/messages", $result);
        exec($result);
    }
}
