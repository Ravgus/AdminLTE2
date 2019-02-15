<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 13.02.19
 * Time: 12:41
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class FileUploader //service to upload files (mostly images) to the server
{
    const PATHS = [ //acceptable paths
        'EMPTY' => '',
        'PRODUCT' => '/products/',
        'USER' => '/users/'
    ];

    private $targetDirectory;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct($targetDirectory, FlashBagInterface $flashBag)
    {
        $this->targetDirectory = $targetDirectory;
        $this->flashBag = $flashBag;
    }

    public function upload(UploadedFile $file, $path = self::PATHS['EMPTY']) //upload files
    {
        if (!in_array($path, self::PATHS)) { //check $path parameter
            $path = self::PATHS['EMPTY'];
        }

        $fileName = md5(uniqid()).'.'.$file->guessExtension(); //generate random name for file

        try {
            $file->move($this->getTargetDirectory($path), $fileName); //save file
        } catch (FileException $e) {
            $this->flashBag->add('error', 'Something went wrong saving the image, please try again later.'); //add error to session
            return null;
        }

        return $this->getPublicPath($path) . $fileName;
    }

    private function getTargetDirectory($path = self::PATHS['EMPTY']) //get path to directory where file will be save
    {
        return $this->targetDirectory . $path;
    }

    private function getPublicPath($path = self::PATHS['EMPTY']) //get path to saved file (for database)
    {
        return 'uploads' . $path;
    }
}