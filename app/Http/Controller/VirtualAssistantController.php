<?php

namespace App\Http\Controller;

use App\Service\AIService\N8nSvc;
use PHPUnit\Exception;

class VirtualAssistantController
{
    public function VirtualAssistantView()
    {
        view("virtual_assistant_view", [
            "title" => "Assistant Virtual"
        ]);
    }

    public function upload_doc_view()
    {
        view("doc_upload_view", [
            "title" => "upload doc"
        ]);
    }

    public function upload_doc()
    {
        try {
            if (!isset($_FILES['document'])) {
                throw new \Exception("No document");
            }

            $file = $_FILES['document'];

            $service = new N8nSvc();
            $res = $service->UploadDoc($file);

            view("doc_upload_view", [
                "title" => "upload doc"
                , "message" => "Upload Successful!"
            ]);
        }catch (Exception $e){
            view("doc_upload_view", [
                "title" => "upload doc"
                , "message" => "Upload Failed!"
            ]);
        }
    }
}