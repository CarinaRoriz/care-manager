<?php
class CuidadorIdoso
{
    var $cod_cuidadorIdoso;
    var $cod_idoso;
    var $cod_usuario;
    var $nome_usuario;


    function FillByObject($obj)
    {
        if (property_exists($obj, 'cod_cuidadorIdoso'))
            $this->cod_cuidadorIdoso = $obj->cod_cuidadorIdoso;

        if (property_exists($obj, 'cod_idoso'))
            $this->cod_idoso = $obj->cod_idoso;

        if (property_exists($obj, 'cod_usuario'))
            $this->cod_usuario = $obj->cod_usuario;

        if (property_exists($obj, 'nome_usuario'))
            $this->nome_usuario = $obj->nome_usuario;
    }

    function FillByDB($dbArray)
    {
        if (is_array($dbArray) && array_key_exists("cod_cuidadorIdoso", $dbArray))
            $this->cod_cuidadorIdoso = $dbArray['cod_cuidadorIdoso'];

        if (is_array($dbArray) && array_key_exists("cod_idoso", $dbArray))
            $this->cod_idoso = $dbArray['cod_idoso'];

        if (is_array($dbArray) && array_key_exists("cod_usuario", $dbArray))
            $this->cod_usuario = $dbArray['cod_usuario'];

        if (is_array($dbArray) && array_key_exists("nome_usuario", $dbArray))
            $this->nome_usuario = $dbArray['nome_usuario'];
    }
}
