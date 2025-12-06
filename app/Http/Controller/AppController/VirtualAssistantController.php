<?php

namespace App\Http\Controller\AppController;

use App\Service\AIService\N8nSvc;
use Exception;

class VirtualAssistantController
{
    public function VirtualAssistantView()
    {
        view("virtual_assistant_view", [
            "title" => "Assistant Virtual"
        ]);
    }

    public function VirtualAssistantVoiceView()
    {
        view("virtual_assistant_voice_view", [
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
            $service->UploadDoc($file);

            view("doc_upload_view", [
                "title" => "upload doc"
                , "message" => "Upload Successful!"
            ]);
        }catch (Exception $e){
            view("doc_upload_view", [
                "title" => "upload doc"
                , "message" => $e->getMessage()
            ]);
        }
    }

    public function doc_list_view(){
        $service = new N8nSvc();
        $docList = $service->GetAllActDoc();

        $isDocAct = $service->GetDocActivationStat();

        view("doc_list", [
            "title" => "Document List"
            , "docList" => $docList
            , "isDocAct" => $isDocAct
        ]);
    }

    public function doc_list_action()
    {
        $service = new N8nSvc();
        $isDocAct = $service->GetDocActivationStat();

        $actionType = $_POST["actionType"] ?? null;
        if ($actionType == null) {
            $docList = $service->GetAllActDoc();
            view("doc_list", [
                "title" => "Document List"
                , "docList" => $docList
                , "notif" => "Error in application, please contact your administrator"
                , "notifType" => "error"
                , "isDocAct" => $isDocAct
            ]);
        }

        if ($actionType == "delete"){
            $docId = $_POST['docId'] ?? null;

            if ($docId == null) {
                $docList = $service->GetAllActDoc();
                view("doc_list", [
                    "title" => "Document List"
                    , "docList" => $docList
                    , "notif" => "Error in application, please contact your administrator"
                    , "notifType" => "error"
                    , "isDocAct" => $isDocAct
                ]);
            }

            try {
                $service->DeleteDoc($docId);
                $docList = $service->GetAllActDoc();
                $isDocAct = $service->GetDocActivationStat();
                view("doc_list", [
                    "title" => "Document List"
                    , "docList" => $docList
                    , "notif" => "Success delete document"
                    , "notifType" => "success"
                    , "isDocAct" => $isDocAct
                ]);
            } catch (Exception $e){
                $docList = $service->GetAllActDoc();
                view("doc_list", [
                    "title" => "Document List"
                    , "docList" => $docList
                    , "notif" => $e->getMessage()
                    , "notifType" => "error"
                    , "isDocAct" => $isDocAct
                ]);
            }
        }

        if ($actionType == "activate"){
            $res = $service->ActivateDoc();
            $isDocAct = $service->GetDocActivationStat();
            $docList = $service->GetAllActDoc();
            view("doc_list", [
                "title" => "Document List",
                "docList" => $docList,
                "notif" => $res["message"] ?? "Unknown result from activation.",
                "notifType" => $res["success"] ? "success" : "error"
                , "isDocAct" => $isDocAct
            ]);
        }
    }

    public function download_doc()
    {
        $docId = $_GET['docId'] ?? null;
        if ($docId == null) {
            throw new Exception("Failed download document, please contact your administrator");
        }

        $service = new N8nSvc();
        try {
            $doc = $service->GetDocById($docId);
        } catch (Exception $e){
            throw new Exception("Failed download document, please contact your administrator");
        }

        $filePath = __DIR__."/../../../../resources/document/".$doc->getDocName();

        if (!$filePath || !file_exists($filePath)) {
            throw new Exception("File not found: " . $doc->getDocName());
        }

        if (ob_get_length()) ob_end_clean();

        $mimeType = mime_content_type($filePath);
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . $doc->getDocName() . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        flush();

        readfile($filePath);
        exit;
    }
}