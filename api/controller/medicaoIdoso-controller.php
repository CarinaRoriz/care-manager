<?php

class MedicacaoIdosoController extends BaseController
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
                case "inativa":
                    $codMedicacaoIdoso = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionInativa($codMedicacaoIdoso);
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
        $medicacaoIdosoRepository = new MedicacaoIdosoRepository();
        $result = $medicacaoIdosoRepository->GetList();

        $listMedicacaoIdoso = array();

        foreach($result as $dbMedicacaoIdoso)
        {
            $modelMedicacaoIdoso = new CuidadorIdoso();
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

    function ActionInativa($codMedicacaoIdoso)
    {
        $medicacaoIdosoRepository = new MedicacaoIdosoRepository();
        $medicacaoIdosoRepository->Inativa($codMedicacaoIdoso);

        $result = $medicacaoIdosoRepository->GetList();

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