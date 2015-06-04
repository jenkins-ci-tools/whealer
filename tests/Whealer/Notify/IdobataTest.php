<?php
namespace Whealer\Test\Notify;
use Whealer\Notify\Services\Idobata;

class IdobataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function get()
    {
        $argument = [
            "API_TOKEN" => "",
            "USER_NAME" => "",
            "ROOM_ID"   => "",
            "END_POINT" => "https://idobata.io/hook/custom/4f18052e-28cb-447a-9704-c12cff0575d4"
        ];
        $commit_id = "4a516a46292655c1c2b15ff6f67897a5333a8171";
        $commit_auther = "aozora0000";
        $commit_comment = "fixed .jenkins.yml";
        $branch = "master";
        $repository_url = "https://github.com/Duckpeller/Duckpeller";
        $idobata = Idobata::getInstance($argument);
        $result = $idobata->get(true, $commit_id, $commit_auther, $commit_comment, $branch, $repository_url);
        $this->assertEquals('curl -d format=html --data-urlencode source=\'<p><span class="label label-success">Build: PASSED</span></p><ul><li>commited by aozora0000 <a href=\'https://github.com/Duckpeller/Duckpeller/commit/4a516a46292655c1c2b15ff6f67897a5333a8171\'>master #4a516a46292655c1c2b15ff6f67897a5333a8171</a></li></ul><pre>fixed .jenkins.yml</pre>\' https://idobata.io/hook/custom/4f18052e-28cb-447a-9704-c12cff0575d4',$result);
    }
}
