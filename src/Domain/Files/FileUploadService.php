<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 29/07/2024
 */

namespace App\Domain\Files;

use Exception;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadService
{
    public function __construct(private readonly SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/img/pictures')] private readonly string $picturesDirectory)
    {
    }

    /**
     * @throws Exception
     */
    public function uploadFile(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->picturesDirectory, $newFilename);
        } catch (FileException $e) {
            throw new Exception($e->getMessage());
        }

        return $newFilename;
    }
}