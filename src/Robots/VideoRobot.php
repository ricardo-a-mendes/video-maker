<?php

namespace VMaker\Robots;

use Exception;
use Imagick;
use ImagickException;
use ImagickPixel;
use VMaker\Traits\SharedFunctions;

class VideoRobot
{
    use SharedFunctions;

//    /**
//     * Resize the images to 1920x1080
//     *
//     * @param string $sourceFolder
//     * @param string $destinationFolder
//     *
//     * @return bool
//     * @throws ImagickException
//     * @throws Exception
//     */
//    public function resizeImages(string $sourceFolder, string $destinationFolder): bool
//    {
//        if (!is_dir($sourceFolder)) {
//            throw new Exception("Folder {$sourceFolder} not found.");
//        }
//
//        if (!is_dir($destinationFolder)) {
//            throw new Exception("Folder {$destinationFolder} does not exist.");
//        }
//
//
//
//        $canvas = $this->resize('');
//        $canvas->writeImage("/application/images/converted/Amb-White-House4.jpg");
//
//        return true;
//    }

    /**
     * Resize the images to 1920x1080
     *
     * @param string $image
     * @param int $width
     * @param int $height
     *
     * @return string Full resized file path
     * @throws ImagickException
     * @throws Exception
     */
    public function resize(string $image, int $width = 1920, int $height = 1080): string
    {
        if (!is_file($image)) {
            throw new Exception("File [{$image}] not found");
        }

        $fileInfo = explode(DIRECTORY_SEPARATOR, $image);
        $fileName = array_pop($fileInfo);
        $fileInfo[] = 'converted';
        $fileInfo[] = $fileName;
        $destination = implode(DIRECTORY_SEPARATOR, $fileInfo);

        $background = new Imagick($image);
        $background->blurImage(0, 9);
        $background->adaptiveResizeImage($width, $height, false);

        $foreground = new Imagick($image);
        $foreground->adaptiveResizeImage($width, $height, true);

        $canvas = new Imagick();
        $canvas->newImage($width, $height, new ImagickPixel("white"));
        $canvas->setImageFormat("png");
        $canvas->compositeImage($background, Imagick::COMPOSITE_OVER, 0, 0);
        $canvas->compositeImageGravity($foreground, Imagick::COMPOSITE_COPY, Imagick::GRAVITY_CENTER);

        $canvas->writeImage($destination);

        return $destination;
    }
}
