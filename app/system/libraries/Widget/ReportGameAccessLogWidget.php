<?php

namespace System\Widgets;

class ReportGameAccessLogWidget extends BaseWidget
{
    public function getContent()
    {
        $view = $this->view;
        $data = $this->params['data'];
        $realuser = $this->params['realuser'];


        echo "<pre>";
        var_dump($data) ;
        die;



        return $this->setView('report/gamesaccesslog', []);
    }
}