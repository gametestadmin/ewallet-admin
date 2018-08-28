<?php
namespace Backoffice\Controllers;

use System\Library\General\Image;

class CaptchaController extends BaseController
{

    public function indexAction()
    {
        $rcode = rand(1000,9999);

        $this->session->set("securitycode", $rcode);

        $image = Image::createImageFromText($rcode);

        // Output the image to browser
        header('Content-type: image/gif');

        imagegif($image);
        imagedestroy($image);die;
    }
}