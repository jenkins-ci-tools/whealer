<?php
namespace Whealer\Notify;

abstract class AbstructService
{
    /**
     * @var Array NotifyAutguments
     * - api_token
     * - user_name
     * - room_id
     * - end_point
     */
    protected $arg;

    /**
     * NitifyServiceConstructor
     * @final
     * @access private
     * @var array $aruguments
     */
    final private function __construct(Array $arguments)
    {
        $arg = array();
        $arg['api_token'] = $arguments["API_TOKEN"];
        $arg['user_name'] = $arguments["USER_NAME"];
        $arg['room_id']   = $arguments["ROOM_ID"];
        $arg['end_point'] = $arguments["END_POINT"];
        $this->arg = (object)$arg;
    }

    /**
     * get SingletonInstance
     * @final
     * @access public
     * @var array $aruguments
     */
    final public static function getInstance(array $arguments)
    {
        $class = get_called_class();
        return new $class($arguments);
    }

    /**
     * sendMessageMethod
     * @abstract
     * @access public
     * @var boolean $status
     * @var string $commit_id
     * @var string $commit_auther
     * @var string $commit_comment
     * @var string $branch
     * @var string $repository_url
     * @return bool
     */
    abstract public function get($status, $commit_id, $commit_auther, $commit_comment, $branch, $repository_url);
}
