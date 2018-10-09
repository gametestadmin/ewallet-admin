<?php
namespace Backoffice\Controllers;

use System\Library\General\Image;
use System\Library\General\Captcha;

class CaptchaController extends BaseController
{

    public function indexAction()
    {
        $captcha = new Captcha();
        $securitycode = $captcha->generateCaptcha();
        $rcode = $securitycode["securitycode"];

        $image = Image::createImageFromText($rcode);

        // Output the image to browser
        header('Content-type: image/gif');


        imagegif($image);
        imagedestroy($image);die;
    }





}