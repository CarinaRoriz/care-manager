<?php

class CuidadorIdosoController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
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
                case "delete":
                    $codCuidadorIdoso = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionDelete($codCuidadorIdoso);
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

    function ActionGetList()
    {
        $cuidadorIdosoRepository = new CuidadorIdosoRepository();
        $result = $cuidadorIdosoRepository->GetList();

        $listCuidadorIdoso = array();

        foreach($result as $dbCuidadorIdoso)
        {
            $modelCuidadorIdoso = new CuidadorIdoso();
            $modelCuidadorIdoso->FillByDB($dbCuidadorIdoso);
            $listCuidadorIdoso[] = $modelCuidadorIdoso;
        }

        ToWrappedJson($listCuidadorIdoso);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $cuidadorIdoso = new CuidadorIdoso();
        $cuidadorIdoso->FillByObject($obj);

        $cuidadorIdosoRepository = new CuidadorIdosoRepository();
        $cuidadorIdosoRepository->Insert($cuidadorIdoso);

        ToWrappedJson($cuidadorIdoso, "Cuidador inserido com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $cuidadorIdoso = new CuidadorIdoso();
        $cuidadorIdoso->FillByObject($obj);

        $cuidadorIdosoRepository = new CuidadorIdosoRepository();
        $cuidadorIdosoRepository->Update($cuidadorIdoso);

        ToWrappedJson($cuidadorIdoso, "Dados atualizados com sucesso");
    }

    function ActionDelete($codCuidadorIdoso)
    {
        $codCuidadorIdosoRepository = new CuidadorIdosoRepository();
        $result = $codCuidadorIdosoRepository->Delete($codCuidadorIdoso);

        if(!$result)
            throw new Warning("Falha ao excluir Perfil.");

        ToWrappedJson("{}", "Cuidador excluido com sucesso");
    }


}