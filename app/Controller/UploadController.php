<?php

namespace App\Controller;
use Exception;

/**
 * |--------------------------------------------------------------------------
 * | Uploads controller
 * |--------------------------------------------------------------------------
 * |
 * | This will serve as the uploads controller.
 * |
 */
class UploadController extends Controller
{

    private $directory = ROOT . '/../public/assets/uploads/';

    /**
     * @todo improve validation/check file type severly
     * Something complex would be to register the ip address of the logged user
     * and keep track of how many times they've uploaded, denying the access
     * for some time after a number of uploads.
     * @return void
     * @throws Exception
     */
    public function image(): void
    {
        if ($this->request->is('POST')) {
            $response['result'] = false;
            if (isset($_FILES['image'])) {
                $file = $_FILES['image'];
                $fileName = $file['name'];
                $fileSize = $file['size'];
                $fileTmp = $file['tmp_name'];
                $fileError = $file['error'];

                $fileExtension = explode('.', $fileName);
                $fileExtension = strtolower(end($fileExtension));

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileError === 0) {
                        if ($fileSize <= 20971520) {
                            $fileNewName = uniqid() . '.' . $fileExtension;
                            $destination = $this->directory . $fileNewName;
                            if (move_uploaded_file($fileTmp, $destination)) {
                                $response['result'] = true;
                                $response['message'] = 'Cover image successfully uploaded';
                                $response['image'] = $fileNewName;
                            } else {
                                $response['message'] = "$fileNewName coudn't be moved, please try again";
                            }
                        } else {
                            $response['message'] = 'Please enter a file < 20MB';
                        }
                    } else {
                        $response['message'] = 'Oups, something went wrong, please try again';
                    }
                } else {
                    $response['message'] = "Please enter one of the accepted image types: 'jpg', 'jpeg', 'png', 'gif'";
                }
            } else {
                $response['message'] = 'No files or wrong files added, please try again';
            }
            $this->newJsonResponse($response);
        } else {
            throw new Exception('Method not allowed!');
        }
    }

    /**
     * @todo REALLY HAVE TO IMPROVE THIS!!!
     * @return void
     * @throws Exception
     */
    public function delete(): void
    {
        if ($this->request->is('POST')) {
            $response['result'] = false;
            $fileToDelete = $this->request->data();
            if (!unlink($this->directory . $fileToDelete)) {
                $response['message'] = "$fileToDelete cannot be deleted due to an error";
            }
            else {
                $response['result'] = true;
                $response['message'] = "$fileToDelete has been deleted";
            }
            $this->newJsonResponse($response);
        } else {
            throw new Exception('Method not allowed!');
        }
    }
}