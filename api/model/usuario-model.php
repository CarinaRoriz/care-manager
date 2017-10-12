<?php

class Usuario
{
    var $cod_usuario;
    var $nome_usuario;
    var $cpf_usuario;
    var $rg_usuario;
    var $telefone_usuario;
    var $celular_usuario;
    var $email_usuario;
    var $login_usuario;
    var $senha_usuario;
    var $cod_perfil;
    var $descricao_perfil;
    var $ativo_usuario;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'cod_usuario'))
            $this->cod_usuario = $obj->cod_usuario;

        if (property_exists($obj, 'nome_usuario'))
            $this->nome_usuario = $obj->nome_usuario;

        if (property_exists($obj, 'cpf_usuario'))
            $this->cpf_usuario = $obj->cpf_usuario;

        if (property_exists($obj, 'rg_usuario'))
            $this->rg_usuario = $obj->rg_usuario;

        if (property_exists($obj, 'telefone_usuario'))
            $this->telefone_usuario = $obj->telefone_usuario;

        if (property_exists($obj, 'celular_usuario'))
            $this->celular_usuario = $obj->celular_usuario;

        if (property_exists($obj, 'email_usuario'))
            $this->email_usuario = $obj->email_usuario;

        if (property_exists($obj, 'login_usuario'))
            $this->login_usuario = $obj->login_usuario;

        if (property_exists($obj, 'senha_usuario'))
            $this->senha_usuario = $obj->senha_usuario;

        if (property_exists($obj, 'cod_perfil'))
            $this->cod_perfil = $obj->cod_perfil;

        if (property_exists($obj, 'descricao_perfil')){
            if($obj->descricao_perfil == 1)
                $this->descricao_perfil = 'Administrador';
            else if($obj->descricao_perfil == 2)
                $this->descricao_perfil = 'Cuidador';
            else if($obj->descricao_perfil == 3)
                $this->descricao_perfil = 'Familiar';
        }

        if (property_exists($obj, 'ativo_usuario'))
            $this->ativo_usuario = $obj->ativo_usuario;
    }

    function FillByDB($dbArray)
    {
        if (is_array($dbArray) && array_key_exists("cod_usuario", $dbArray))
            $this->cod_usuario = $dbArray['cod_usuario'];

        if (is_array($dbArray) && array_key_exists("nome_usuario", $dbArray))
            $this->nome_usuario = $dbArray['nome_usuario'];

        if (is_array($dbArray) && array_key_exists("cpf_usuario", $dbArray))
            $this->cpf_usuario = $dbArray['cpf_usuario'];

        if (is_array($dbArray) && array_key_exists("rg_usuario", $dbArray))
            $this->rg_usuario = $dbArray['rg_usuario'];

        if (is_array($dbArray) && array_key_exists("telefone_usuario", $dbArray))
            $this->telefone_usuario = $dbArray['telefone_usuario'];

        if (is_array($dbArray) && array_key_exists("celular_usuario", $dbArray))
            $this->celular_usuario = $dbArray['celular_usuario'];

        if (is_array($dbArray) && array_key_exists("email_usuario", $dbArray))
            $this->email_usuario = $dbArray['email_usuario'];

        if (is_array($dbArray) && array_key_exists("login_usuario", $dbArray))
            $this->login_usuario = $dbArray['login_usuario'];

        if (is_array($dbArray) && array_key_exists("cod_perfil", $dbArray)){
            $this->cod_perfil = $dbArray['cod_perfil'];

            if($this->cod_perfil == 1)
                $this->descricao_perfil = 'Administrador';
            else if($this->cod_perfil == 2)
                $this->descricao_perfil = 'Cuidador';
            else if($this->cod_perfil == 3)
                $this->descricao_perfil = 'Familiar';
        }

        if (is_array($dbArray) && array_key_exists("ativo_usuario", $dbArray)){
            $situcao = $dbArray['ativo_usuario'];

            if($situcao == 0)
                $this->ativo_usuario = false;
            else
                $this->ativo_usuario = true;
        }
    }
}
