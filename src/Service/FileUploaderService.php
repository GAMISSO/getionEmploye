<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderService
{
    public function upload(UploadedFile $file): string;
}