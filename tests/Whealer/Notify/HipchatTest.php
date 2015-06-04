<?php
namespace Whealer\Test\Notify;
use Whealer\Notify\Services\Hipchat;

class HipchatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function get()
    {
        $argument = [
            "API_TOKEN" => "test_api_token",
            "USER_NAME" => "Jenkins",
            "ROOM_ID"   => "123456",
            "END_POINT"  => ""
        ];
        $commit_id = "4a516a46292655c1c2b15ff6f67897a5333a8171";
        $commit_auther = "aozora0000";
        $commit_comment = "fixed .jenkins.yml";
        $branch = "master";
        $repository_url = "https://github.com/Duckpeller/Duckpeller";
        $hipchat = Hipchat::getInstance($argument);

        $result = $hipchat->get(true, $commit_id, $commit_auther, $commit_comment, $branch, $repository_url);
        $this->assertEquals("curl -d \"room_id=123456&from=Jenkins&color=GREEN&notify=1\" --data-urlencode message=\"Build: PASSED! \n<a href='https://github.com/Duckpeller/Duckpeller/commit/4a516a46292655c1c2b15ff6f67897a5333a8171'>master #4a516a46292655c1c2b15ff6f67897a5333a8171@aozora0000</a>\" https://api.hipchat.com/v1/rooms/message?auth_token=test_api_token&format=json", $result);
    }
}
