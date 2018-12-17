<?php

class SampleTask extends \Phalcon\Cli\Task
{

    //Execute: php public/cli.php Sample awesome
    public function awesomeAction()
    {
        echo "This is an awesome application\nNew line here";
    }
}