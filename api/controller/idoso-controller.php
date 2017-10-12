<?php

class IdosoController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $codIdoso = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($codIdoso);
                    break;
                case "list":
                    $this->ActionGetList();
                    break;
                case "insert":
                    $data = file_get_contents("php://input");
                    $this->ActionInsert($data);
                    break;
                case "update":
                    $data = file_get_contents("php://input");
                    $this->ActionUpdate($data);
                    break;
                case "inativa":
                    $codCuidadorIdoso = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionInativa($codCuidadorIdoso);
                    break;
                case "ativa":
                    $codCuidadorIdoso = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionAtiva($codCuidadorIdoso);
                    break;
                default:
                    ToErrorJson("Action not found");
            }
        } catch (Warning $e) {
            ToErrorJson($e->getMessage());
        } catch (Exception $e) {
            ToExceptionJson($e);
        }
    }

    function ActionGetThis($codIdoso)
    {
        $idosoRepository = new IdosoRepository();
        $result = $idosoRepository->GetThis($codIdoso);
        $idoso = new Idoso();
        $idoso->FillByDB($result);

        if(!$idoso->cod_idoso)
            throw new Warning("Idoso não encontrado");

        ToWrappedJson($idoso);
    }

    function ActionGetList()
    {
        $idosoRepository = new IdosoRepository();
        $result = $idosoRepository->GetList();

        $listIdoso = array();

        foreach($result as $dbIdoso)
        {
            $modelIdoso = new Idoso();
            $modelIdoso->FillByDB($dbIdoso);
            $listIdoso[] = $modelIdoso;
        }

        ToWrappedJson($listIdoso);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $idoso = new Idoso();
        $idoso->FillByObject($obj);

        $idosoRepository = new IdosoRepository();
        $idosoRepository->Insert($idoso);

        ToWrappedJson($idoso, "Idoso inserido com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $idoso = new Idoso();
        $idoso->FillByObject($obj);

        $idosoRepository = new IdosoRepository();
        $idosoRepository->Update($idoso);

        ToWrappedJson($idoso, "Dados atualizados com sucesso");
    }

    function ActionInativa($codIdoso)
    {
        $idosoRepository = new IdosoRepository();
        $idosoRepository->Inativa($codIdoso);

        $result = $idosoRepository->GetList();

        $listIdoso = array();

        foreach($result as $dbIdoso)
        {
            $modelIdoso = new Idoso();
            $modelIdoso->FillByDB($dbIdoso);
            $listIdoso[] = $modelIdoso;
        }
        ToWrappedJson($listIdoso, "Idoso inativado com sucesso");
    }

    function ActionAtiva($codIdoso)
    {
        $idosoRepository = new IdosoRepository();
        $idosoRepository->Ativa($codIdoso);

        $result = $idosoRepository->GetList();

        $listIdoso = array();

        foreach($result as $dbIdoso)
        {
            $modelIdoso = new Idoso();
            $modelIdoso->FillByDB($dbIdoso);
            $listIdoso[] = $modelIdoso;
        }
        ToWrappedJson($listIdoso, "Idoso ativado com sucesso");
    }

}