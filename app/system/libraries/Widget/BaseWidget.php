<?php

namespace System\Widgets;

class BaseWidget extends \Phalcon\DI\Injectable
{
    protected $params;

    public function __construct(array $params = array())
    {
        $this->_apps = $this->config->apps;
        $this->_environment = $this->config->environment;
//        $this->_webConfig = $config->{$this->_environment}->{$this->_apps};

        $this->params = $params;
    }

    public function getContent()
    {
        return FALSE;
    }

    /**
     * @param $file
     * @param array $data
     * @return string
     */
    public function setView($file, $data = array())
    {
        $view = $this->di->getView();

        ob_start();
        if ($this->dispatcher->getModuleName())
        {
            /**
             *
             * @var \Phalcon\Mvc\View $view
             */
            $view->partial('../../../../views/'.$this->config->template.'/widgets/' . $file, $data);
        }
        else
        {
            /**
             *
             * @var \Phalcon\Mvc\View $view
             */
            $view->partial('widgets/' . $file, $data);
        }
        return ob_get_clean();
    }
}
