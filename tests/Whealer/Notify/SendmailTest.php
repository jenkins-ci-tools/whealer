<?php
namespace Whealer\Test\Notify;
use Whealer\Notify\Services\Sendmail;

class SendmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function get()
    {
        $argument = [
            "API_TOKEN" => "",
            "USER_NAME" => "aozora0000@gmail.com",
            "ROOM_ID"   => "",
            "END_POINT" => "aozora0000@gmail.com,info@smart-ero.net"
        ];
        $commit_id = "4a516a46292655c1c2b15ff6f67897a5333a8171";
        $commit_auther = "aozora0000";
        $commit_comment = "fixed .jenkins.yml";
        $branch = "master";
        $repository_url = "https://github.com/Duckpeller/Duckpeller";
        $idobata = Sendmail::getInstance($argument);
        $result = $idobata->get(true, $commit_id, $commit_auther, $commit_comment, $branch, $repository_url);
        $this->assertEquals("cat <<EOM | /usr/sbin/sendmail -t -i From: aozora0000@gmail.com\nTo: aozora0000@gmail.com,info@smart-ero.net\nSubject: Build: PASSED master#4a516a46292655c1c2b15ff6f67897a5333a8171\nContent-Type: text/html; charset=UTF-8\nContent-Transfer-Encoding: 8bit\nMIME-Version: 1.0\n\nBuild:  <span style='font-weight:bold;color:#CFCFCF;background:#00FF00;'>PASSED</span><br >branch: master<br >commit: <a href='https://github.com/Duckpeller/Duckpeller/commit/4a516a46292655c1c2b15ff6f67897a5333a8171'>4a516a46292655c1c2b15ff6f67897a5333a8171</a><br >auther: aozora0000<br ><br >message:<br>fixed .jenkins.yml<br >",$result);
    }
}
