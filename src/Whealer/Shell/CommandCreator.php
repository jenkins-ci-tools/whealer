<?php
namespace Whealer\Shell;

class CommandCreator
{
    /**
     * System Command Creator
     * @access public
     * @param string $bin
     * @param array $arguments
     * @param string $params
     * @return string
     */
    public static function get($bin, array $arguments = array(), $params = "")
    {
        $args = self::createArgs($arguments);
        return "{$bin} {$args} {$params}";
    }

    /**
     * System Command Execute From which
     * @access public
     * @param string $bin
     * @param array $arguments
     * @param string $params
     * @return boolean
     */
    public static function which($bin)
    {
        $output = array();
        exec("which {$bin}", $output);
        return $output[0];
    }

    /**
     * Command Pipeline Join
     * @access public
     * @param array $commands
     * @return string
     */
    public static function pipe(array $commands)
    {
        return join(" | ", $commands);
    }

    /**
     * Command Join "&&"
     * @access public
     * @param array $commands
     * @return string
     */
    public static function join(array $commands)
    {
        return join(" && ", $commands);
    }

    /**
     * CreateCommandline ArgumentStrings
     * @access private
     * @var array $arguments
     * @return string
     */
    private static function createArgs(array $arguments = array())
    {
        $argument_strings = array();
        if(empty($arguments)) {
            return "";
        }
        foreach($arguments as $key=>$value) {
            if(is_int($key)) {
                $argument_strings[] = "{$value}";
            } else {
                $argument_strings[] = "{$key} {$value}";
            }
        }
        return join(" ", $argument_strings);
    }
}
