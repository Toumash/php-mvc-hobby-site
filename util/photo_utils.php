<?php

class PhotoUtils
{
    /**
     * Use example
     * <code>watermark("image2.jpg", "Copyright Toumash", "arial.ttf", 14);</code>
     * @param $src string path to original file
     * @param $dest string new image destination path
     * @param $text string text to be drawn
     * @param $font string name of the system font to use with extension
     * @param $size integer font size
     * @return bool|null|string Returns path to watermarked image on success.
     * Returns path to watermarked image on success.
     * Returns false if wrong extension
     * Returns null if system error occurs
     */
    public static function watermark($src, $dest, $text, $size, $font = 'arial.ttf')
    {
        $img = null;
        $name = substr($src, 0, strlen($src) - 4);
        $ext = substr($src, strlen($src) - 4);
        if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
            return false;
        }
        switch ($ext) {
            case 'gif':$img = imagecreatefromgif($src);break;
            case 'jpg':$img = imagecreatefromjpeg($src);break;
            case 'jpeg':$img = imagecreatefromjpeg($src);break;
            case 'png':$img = imagecreatefrompng($src);break;
        }
        if (!$img) {
            return null;
        }

        $sW = imagesx($img);
        $sH = imagesy($img);

        $arr = imagettfbbox($size, 0, $font, $text);
        $width = abs($arr[2] - $arr[0]) + 5; // lower right X - lower left X
        $height = abs($arr[1] - $arr[7]) + 1;// lower left Y - upper left Y

        $color = imagecolorallocate($img, 255, 255, 255); // while

        $posX = $sW - $width;
        $posY = $sH - $height;
        imagettftext($img, $size, 0, $posX, $posY - 5, $color, $font, $text);

        switch ($ext) {
            case 'gif':imagegif($img, $dest);break;
            case 'png':imagepng($img, $dest);break;
            case 'jpg':imagejpeg($img, $dest);break;
            case 'jpeg':imagejpeg($img, $dest);break;
        }
        imagedestroy($img);
        return true;
    }

    public static function createThumbnail($src, $dest, $newWidth, $newHeight)
    {
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        $desired_height = $newHeight;

        $img = imagecreatetruecolor($newWidth, $desired_height);

        imagecopyresampled($img, $source_image, 0, 0, 0, 0, $newWidth, $desired_height, $width, $height);
        imagedestroy($source_image);

        imagejpeg($img, $dest);
        imagedestroy($img);
    }

    public static function getMimeType($fileName){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        return finfo_file($finfo, $fileName);
    }
}