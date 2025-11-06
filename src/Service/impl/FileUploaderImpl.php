<?php
namespace App\Service\impl;
use App\Service\FileUploaderService;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
class FileUploaderImpl implements FileUploaderService
{
    public function __construct(private readonly string $uploadDir,private readonly SluggerInterface $slugger)
    {
        
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);//nom sans extension et sans caractere special
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->uploadDir, $newFilename);
        } catch (FileException $e) {
            throw new \Exception("Erreur lors du téléchargement du fichier : " . $e->getMessage());
        }

        return $newFilename;
    }
}