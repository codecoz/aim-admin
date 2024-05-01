<?php

namespace CodeCoz\AimAdmin\Http\Controllers;

use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use CodeCoz\AimAdmin\Http\Requests\FileUploadRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TinyMceFileController extends Controller
{
    public function fileUpload(FileUploadRequest $fileUpload): JsonResponse
    {
        try {

            $destinationPath = 'uploads/files';

            $file = $fileUpload->file('upload');

            $fileUrl = $this->upload($file, $destinationPath);

            if (!$fileUrl) {
                return response()->json([
                    'error' => 'Failed to upload the file.'
                ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json(['fileName' => $fileUpload->file('upload')->getClientOriginalName(), 'uploaded' => 1, 'url' => asset($fileUrl)], ResponseAlias::HTTP_OK);

        } catch (NotFoundException $e) {
            return response()->json([
                'error' => 'NotFoundException occurred: ' . $e->getMessage()
            ], ResponseAlias::HTTP_BAD_REQUEST);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {

        }
    }

    /**
     * @throws ValidationException
     */
    function upload(UploadedFile $file, $uploadPath): ?string
    {
        // Ensure the upload path exists
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        return $file->storePublicly($uploadPath);
    }

}
