<?php

class Idoso
{
    var $cod_idoso;
    var $nome_idoso;
    var $cpf_idoso;
    var $rg_idoso;
    var $dataNascimento_idoso;
    var $telefone_idoso;
    var $celulàr_idoso;
    var $email_idoso;
    var $ativo_idoso;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'cod_idoso'))
            $this->cod_idoso = $obj->cod_idoso;

        if (property_exists($obj, 'nome_idoso'))
            $this->nome_idoso = $obj->nome_idoso;

        if (property_exists($obj, 'cpf_idoso'))
            $this->cpf_idoso = $obj->cpf_idoso;

        if (property_exists($obj, 'rg_idoso'))
            $this->rg_idoso = $obj->rg_idoso;

        if (property_exists($obj, 'dataNascimento_idoso'))
            $this->dataNascimento_idoso = $obj->dataNascimento_idoso;

        if (property_exists($obj, 'telefone_idoso'))
            $this->telefone_idoso = $obj->telefone_idoso;

        if (property_exists($obj, 'celulàr_idoso'))
            $this->celulàr_idoso = $obj->celulàr_idoso;

        if (property_exists($obj, 'email_idoso'))
            $this->email_idoso = $obj->email_idoso;

        if (property_exists($obj, 'ativo_idoso'))
            $this->ativo_idoso = $obj->ativo_idoso;
    }

    function FillByDB($dbArray)
    {
        if (is_array($dbArray) && array_key_exists("cod_idoso", $dbArray))
            $this->cod_idoso = $dbArray['cod_idoso'];

        if (is_array($dbArray) && array_key_exists("nome_idoso", $dbArray))
            $this->nome_idoso = $dbArray['nome_idoso'];

        if (is_array($dbArray) && array_key_exists("cpf_idoso", $dbArray))
            $this->cpf_idoso = $dbArray['cpf_idoso'];

        if (is_array($dbArray) && array_key_exists("rg_idoso", $dbArray))
            $this->rg_idoso = $dbArray['rg_idoso'];

        if (is_array($dbArray) && array_key_exists("dataNascimento_idoso", $dbArray)){
            $data = $dbArray['dataNascimento_idoso'];
            $Dta_Nascimento = DateTime::createFromFormat("Y-m-d H:i:s", $data);
            $Dta_Nascimento = date_format($Dta_Nascimento, "d/m/Y");

            $this->dataNascimento_idoso = $Dta_Nascimento;
        }

        if (is_array($dbArray) && array_key_exists("telefone_idoso", $dbArray))
            $this->telefone_idoso = $dbArray['telefone_idoso'];

        if (is_array($dbArray) && array_key_exists("celulàr_idoso", $dbArray))
            $this->celulàr_idoso = $dbArray['celulàr_idoso'];

        if (is_array($dbArray) && array_key_exists("email_idoso", $dbArray))
            $this->email_idoso = $dbArray['email_idoso'];

        if (is_array($dbArray) && array_key_exists("ativo_idoso", $dbArray)){
            $situcao = $dbArray['ativo_idoso'];

            if($situcao == 0)
                $this->ativo_idoso = false;
            else
                $this->ativo_idoso = true;
        }
    }
}
