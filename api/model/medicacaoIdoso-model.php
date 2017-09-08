<?php

class MedicacaoIdoso
{
    var $cod_medicacaoIdoso;
    var $descricao_medicacaoIdoso;
    var $horario_medicacaoIdoso;
    var $ativo_medicacaoIdoso;
    var $cod_idoso;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'cod_medicacaoIdoso'))
            $this->cod_medicacaoIdoso = $obj->cod_medicacaoIdoso;

        if (property_exists($obj, 'descricao_medicacaoIdoso'))
            $this->descricao_medicacaoIdoso = $obj->descricao_medicacaoIdoso;

        if (property_exists($obj, 'horario_medicacaoIdoso'))
            $this->horario_medicacaoIdoso = $obj->horario_medicacaoIdoso;

        if (property_exists($obj, 'ativo_medicacaoIdoso'))
            $this->ativo_medicacaoIdoso = $obj->ativo_medicacaoIdoso;

        if (property_exists($obj, 'cod_idoso'))
            $this->cod_idoso = $obj->cod_idoso;
    }

    function FillByDB($dbArray)
    {
        if (is_array($dbArray) && array_key_exists("cod_medicacaoIdoso", $dbArray))
            $this->cod_medicacaoIdoso = $dbArray['cod_medicacaoIdoso'];

        if (is_array($dbArray) && array_key_exists("descricao_medicacaoIdoso", $dbArray))
            $this->descricao_medicacaoIdoso = $dbArray['descricao_medicacaoIdoso'];

        if (is_array($dbArray) && array_key_exists("horario_medicacaoIdoso", $dbArray))
            $this->horario_medicacaoIdoso = $dbArray['horario_medicacaoIdoso'];

        if (is_array($dbArray) && array_key_exists("ativo_medicacaoIdoso", $dbArray))
            $this->ativo_medicacaoIdoso = $dbArray['ativo_medicacaoIdoso'];

        if (is_array($dbArray) && array_key_exists("cod_idoso", $dbArray))
            $this->cod_idoso = $dbArray['cod_idoso'];
    }
}
