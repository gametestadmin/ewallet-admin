<?php
namespace System\Library\General;

class Captcha extends \System\Library\Main
{
    public function checkCatpcha($data){
        $catpcha = $this->session->get("securitycode");
        if($data == $catpcha["securitycode"]){
            $check = true ;
        } else {
            $check = false ;
        }
        return $check ;
    }

    public function checkCaptchaTime()
    {
        $minutes = "+1 minutes";
        $securitytime = $this->session->get("securitycode");

        $time = strtotime($minutes, $securitytime["securitytime"]);

        if($time >= strtotime("now")){
            $check = true ;
        } else {
            $check = false ;
        }
        return $check;
    }

    public function generateCaptcha()
    {
        if($this->session->has("securitycode")){
            $this->session->remove("securitycode");
        }
        $rcode = rand(1000,9999);
        $securitycode = array(
            "securitycode" => $rcode ,
            "securitytime" => time() ,

        );
        $this->session->set("securitycode", $securitycode);


        return $securitycode ;
    }

    //TODO :: testing time for captcha
//    protected function checktime(){
//        $securitytime = $this->session->get("securitycode");
//        $time = date("Y-m-d H:i:s",strtotime("+1 minutes", $securitytime["securitytime"]));
//        if($time >= date("Y-m-d H:i:s")){
//            $check = true ;
//        } else {
//            $check = false ;
//        }
//        echo "<pre>";
//        var_dump($securitytime);
//        var_dump($time);
//        var_dump(date("Y-m-d H:i:s"));
//        var_dump($check); die;
//    }

}
