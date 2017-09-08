<?php

class UsuarioController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $codUsuario = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($codUsuario);
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
                    $codUsuario = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionInativa($codUsuario);
                    break;
                case "ativa":
                    $codUsuario = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionAtiva($codUsuario);
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
        $usuarioRepository = new UsuarioRepository();
        $result = $usuarioRepository->GetList();

        $listUsuario = array();

        foreach($result as $dbUsuario)
        {
            $modelUsuario = new Usuario();
            $modelUsuario->FillByDB($dbUsuario);
            $listUsuario[] = $modelUsuario;
        }

        ToWrappedJson($listUsuario);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $usuario = new Usuario();
        $usuario->FillByObject($obj);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Insert($usuario);

        ToWrappedJson($usuario, "Usuário inserido com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $usuario = new Usuario();
        $usuario->FillByObject($obj);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Update($usuario);

        ToWrappedJson($usuario, "Dados atualizados com sucesso");
    }

    function ActionInativa($codUsuario)
    {
        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Inativa($codUsuario);

        $result = $usuarioRepository->GetList();

        $listUsuario = array();

        foreach($result as $dbUsuario)
        {
            $modelUsuario = new Usuario();
            $modelUsuario->FillByDB($dbUsuario);
            $listUsuario[] = $modelUsuario;
        }
        ToWrappedJson($listUsuario, "Usuário inativado com sucesso");
    }

    function ActionAtiva($codUsuario)
    {
        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Ativa($codUsuario);

        $result = $usuarioRepository->GetList();

        $listUsuario = array();

        foreach($result as $dbUsuario)
        {
            $modelUsuario = new Usuario();
            $modelUsuario->FillByDB($dbUsuario);
            $listUsuario[] = $modelUsuario;
        }
        ToWrappedJson($listUsuario, "Usuário ativado com sucesso");
    }

}