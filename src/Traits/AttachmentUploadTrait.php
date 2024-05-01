<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Traits;

use Illuminate\Support\Facades\Http;
use CodeCoz\AimAdmin\Constants\AG3;

trait AttachmentUploadTrait
{
    public function upload($image)
    {
        if ($image && $image->isValid()) {
            $processedFile = $this->processAttachment($image);
            $response = Http::request()->post(AG3::USER_FILE_UPLOAD, [
                'fileName' => $processedFile['fileName'],
                'fileType' => $processedFile['fileType'],
                'fileContent' => $processedFile['fileContent'],
            ]);

            if ($response->ok()) {
                return json_decode($response->body())->data;
            }
        }
        return response()->json(['error' => 'Invalid or no image provided'], 400);
    }


    public function processAttachment($file): array
    {
        if ($file && $file->isValid()) {
            $attachmentData = file_get_contents($file->getRealPath());
            $base64String = base64_encode($attachmentData);
            $extension = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();

            return [
                'fileName' => $name,
                'fileType' => $extension,
                'fileContent' => $base64String,
            ];
        }

        // Handle the case where the file is not valid or not provided
        return [
            'error' => 'Invalid or no file provided',
        ];
    }


    public function getBase64Attachment(?string $fileId): ?string
    {
        if ($fileId == null) {
            return null;
        }

        $response = Http::request()->get(AG3::GET_FILE, [
            'fileID' => $fileId
        ]);

        if ($response->ok()) {
            return json_decode($response->body())->data;
        }

        return "";
    }

}
