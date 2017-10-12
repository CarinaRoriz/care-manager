<?php

class MedicacaoIdosoController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "list":
                    $codIdoso = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetList($codIdoso);
                    break;
                case "insert":
                    $data = file_get_contents("php://input");
                    $this->ActionInsert($data);
                    break;
                case "inativa":
                    $inativa = file_get_contents("php://input");
                    $this->ActionInativa($inativa);
                    break;
                case "ativa":
                    $ativa = file_get_contents("php://input");
                    $this->ActionAtiva($ativa);
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

    function ActionGetList($codIdoso)
    {
        $medicacaoIdosoRepository = new MedicacaoIdosoRepository();
        $result = $medicacaoIdosoRepository->GetListByIdoso($codIdoso);

        $listMedicacaoIdoso = array();

        foreach($result as $dbMedicacaoIdoso)
        {
            $modelMedicacaoIdoso = new MedicacaoIdoso();
            $modelMedicacaoIdoso->FillByDB($dbMedicacaoIdoso);
            $listMedicacaoIdoso[] = $modelMedicacaoIdoso;
        }

        ToWrappedJson($listMedicacaoIdoso);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $medicacaoIdoso = new MedicacaoIdoso();
        $medicacaoIdoso->FillByObject($obj);

        $medicacaoIdosoRepository = new MedicacaoIdosoRepository();
        $medicacaoIdosoRepository->Insert($medicacaoIdoso);

        ToWrappedJson($medicacaoIdoso, "Medicação inserida com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $medicacaoIdoso = new MedicacaoIdoso();
        $medicacaoIdoso->FillByObject($obj);

        $medicacaoIdosoRepository = new MedicacaoIdosoRepository();
        $medicacaoIdosoRepository->Update($medicacaoIdoso);

        ToWrappedJson($medicacaoIdoso, "Dados atualizados com sucesso");
    }

    function ActionAtiva($data)
    {
        $obj = json_decode($data);

        $medicacaoIdosoRepository = new MedicacaoIdosoRepository();
        $medicacaoIdosoRepository->Ativa($obj->cod_medicacaoIdoso);

        $result = $medicacaoIdosoRepository->GetListByIdoso($obj->cod_idoso);

        $listMedicacaoIdoso = array();

        foreach($result as $dbMedicacaoIdoso)
        {
            $modelMedicacaoIdoso = new MedicacaoIdoso();
            $modelMedicacaoIdoso->FillByDB($dbMedicacaoIdoso);
            $listMedicacaoIdoso[] = $modelMedicacaoIdoso;
        }
        ToWrappedJson($listMedicacaoIdoso, "Medicação ativada com sucesso");
    }

    function ActionInativa($data)
    {
        $obj = json_decode($data);

        $medicacaoIdosoRepository = new MedicacaoIdosoRepository();
        $medicacaoIdosoRepository->Inativa($obj->cod_medicacaoIdoso);

        $result = $medicacaoIdosoRepository->GetListByIdoso($obj->cod_idoso);

        $listMedicacaoIdoso = array();

        foreach($result as $dbMedicacaoIdoso)
        {
            $modelMedicacaoIdoso = new MedicacaoIdoso();
            $modelMedicacaoIdoso->FillByDB($dbMedicacaoIdoso);
            $listMedicacaoIdoso[] = $modelMedicacaoIdoso;
        }
        ToWrappedJson($listMedicacaoIdoso, "Medicação inativada com sucesso");
    }

}