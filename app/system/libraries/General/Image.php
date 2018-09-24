<?php
namespace System\Library\General;

class Image
{
    public static function createImageFromText($text) {
        // Create a new image instance
        $im = \imagecreatetruecolor(60, 25);

        // Make the background white
//        $backgroundColor = \hexdec("262626");
        $backgroundColor = \hexdec("555555");
        \imagefilledrectangle($im, 0, 0, 105, 25, $backgroundColor);

        // Replace path by your own font path
        $font = __DIR__.'/../../../../public/assets/thirdparty/fonts/nexa/nexa_free_bold-webfont.ttf';

        // Add some shadow to the text
        //$fonts_color = "0xFFFFFF";
        $font_color = \hexdec("ffffff");
        \imagettftext($im, 16, 0, 3, 20, $font_color, $font, $text);

        return($im);
    }
}
