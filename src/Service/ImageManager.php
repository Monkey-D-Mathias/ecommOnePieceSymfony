<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class ImageManager 
{
    protected $targetDirectory;
    protected $subDirectory = "/images";

    public function __construct($directory)
    { 
        $this->targetDirectory = $directory;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function getDirectory($public): string
    {
        if ($public === true) {
            $directory = $this->targetDirectory.'/public';
        } else {
            $directory = $this->targetDirectory.'/private';
        }

        return $directory.$this->subDirectory;
    }

    public function upload(UploadedFile $file, bool $public = false): string
    {
        $fileName = null;
       // $file_exists($this->targetDirectory."".$this->subDirectory.'/'.$fileName);

       if (!file_exists($this->getDirectory($public))){
            mkdir($this->getDirectory($public), 0644, true);
       }

       $count = 0;
       $nb = 10;

        while($count < $nb && $fileName == "" || file_exists($this->getDirectory($public).'/'.$fileName)) {
            $fileName = md5($file->getBasename()).'_'.uniqid('',true).$file->guessExtension();
            $count ++;
        }

        if ($count >= $nb) {
            throw new \Exception("Impossible de générer un nom de fichier unique aprés ".$count." tentatives");
        }

        $file->move($this->getDirectory($public), $fileName);

        return $fileName;
    }
}