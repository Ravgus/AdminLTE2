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

class FileUploader
{
    const PATHS = [
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

    public function upload(UploadedFile $file, $path = self::PATHS['EMPTY'])
    {
        if (!in_array($path, self::PATHS)) {
            $path = self::PATHS['EMPTY'];
        }

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory($path), $fileName);
        } catch (FileException $e) {
            $this->flashBag->add('error', 'Something went wrong saving the image, please try again later.');
            return null;
        }

        return $this->getPublicPath($path) . $fileName;
    }

    public function getTargetDirectory($path = self::PATHS['EMPTY'])
    {
        return $this->targetDirectory . $path;
    }

    public function getPublicPath($path = self::PATHS['EMPTY'])
    {
        return 'uploads' . $path;
    }
}