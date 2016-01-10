<?php
define('DEFAULT_FONT', ROOT . '/arial.ttf');

class PhotoUtils
{

    /**
     * Use example
     * <code>watermark("image2.jpg", "Copyright Toumash", 14, "arial.ttf");</code>
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
    public static function watermark($src, $dest, $text, $size = 15, $font = DEFAULT_FONT)
    {
        $img = null;
        $name = substr($src, 0, strlen($src) - 3);
        $ext = substr($src, strlen($src) - 3);
        if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
            return false;
        }
        switch ($ext) {
            case 'gif':
                $img = imagecreatefromgif($src);
                break;
            case 'jpg':
                $img = imagecreatefromjpeg($src);
                break;
            case 'jpeg':
                $img = imagecreatefromjpeg($src);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                break;
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
            case 'gif':
                imagegif($img, $dest);
                break;
            case 'png':
                imagepng($img, $dest);
                break;
            case 'jpg':
                imagejpeg($img, $dest);
                break;
            case 'jpeg':
                imagejpeg($img, $dest);
                break;
        }
        imagedestroy($img);
        return true;
    }

    public static function createThumbnail($src, $dest, $newWidth, $newHeight)
    {
        $ext = substr($src, strlen($src) - 3);
        if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
            return false;
        }
        $source_image = null;
        switch ($ext) {
            case 'gif':
                $source_image = imagecreatefromgif($src);
                break;
            case 'jpg':
                $source_image = imagecreatefromjpeg($src);
                break;
            case 'jpeg':
                $source_image = imagecreatefromjpeg($src);
                break;
            case 'png':
                $source_image = imagecreatefrompng($src);
                break;
        }
        if (!$source_image) {
            return false;
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        $desired_height = $newHeight;

        $img = imagecreatetruecolor($newWidth, $desired_height);

        imagecopyresampled($img, $source_image, 0, 0, 0, 0, $newWidth, $desired_height, $width, $height);
        imagedestroy($source_image);
        switch ($ext) {
            case 'gif':
                imagegif($img, $dest);
                break;
            case 'png':
                imagepng($img, $dest);
                break;
            case 'jpg':
                imagejpeg($img, $dest);
                break;
            case 'jpeg':
                imagejpeg($img, $dest);
                break;
        }
        imagedestroy($img);
        imagedestroy($img);
        return true;
    }

    public static function getMimeType($fileName)
    {
        if (!function_exists('finfo_open')) {
            return self::minimime($fileName);
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        return finfo_file($finfo, $fileName);
    }

    private static function minimime($fname)
    {
        $fh = fopen($fname, 'rb');
        if ($fh) {
            $bytes6 = fread($fh, 6);
            fclose($fh);
            if ($bytes6 === false) return false;
            if (substr($bytes6, 0, 3) == "\xff\xd8\xff") return 'image/jpeg';
            if ($bytes6 == "\x89PNG\x0d\x0a") return 'image/png';
            if ($bytes6 == "GIF87a" || $bytes6 == "GIF89a") return 'image/gif';
            return 'application/octet-stream';
        }
        return false;
    }
}