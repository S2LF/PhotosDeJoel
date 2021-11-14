<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, $newFileName, $directory, $exif = null)
    {
        // $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $newFileName);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            
            $file->move($this->getTargetDirectory().$directory, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            $this->addFlash("error", "Une problème est survenu lors de l'upload de l'image");
        }
        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}