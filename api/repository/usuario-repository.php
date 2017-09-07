<?php
require_once "base-repository.php";

class UsuarioRepository extends BaseRepository
{
    function GetThis($codUsuario){
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM tb_usuario WHERE cod_usuario = :codUsuario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codUsuario', $codUsuario);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList(){
        $conn = $this->db->getConnection();

        $sql = "SELECT cod_usuario, nome_usuario, cpf_usuario, rg_usuario, telefone_usuario, celulàr_usuario, email_usuario, login_usuario, senha_usuario, 
                case situacao_usuario when 1 then 'Ativo' else 'Inativo' end as descricaoSituacao, case cod_perfil when 1 then 'Administrativo' when 2 then 'Cuidador' else 'Parente' end as descricaoPerfil 
                FROM tb_idoso";

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(Usuario &$usuario){
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM tb_usuario WHERE cpf_usuario = :cpf_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cpf_usuario', $usuario->cpf_usuario);
        $stm->execute();

        if($stm->rowCount() > 0)
            throw  new Warning("Usuário já cadastrado!");

        $sqlInsert = 'INSERT INTO tb_usuario (nome_usuario, cpf_usuario, rg_usuario, telefone_usuario, celulàr_usuario, email_usuario, login_usuario, senha_usuario, situacao_usuario, cod_perfil) 
                      VALUES (:nome_usuario, :cpf_usuario, :rg_usuario, :telefone_usuario, :celulàr_usuario, :email_usuario, :login_usuario, :senha_usuario, 1, :cod_perfil)';

        $stmInsert = $conn->prepare($sqlInsert);
        $stmInsert->bindParam(':nome_usuario', $usuario->nome_usuario);
        $stmInsert->bindParam(':cpf_usuario', $usuario->cpf_usuario);
        $stmInsert->bindParam(':rg_usuario', $usuario->rg_usuario);
        $stmInsert->bindParam(':telefone_usuario', $usuario->telefone_usuario);
        $stmInsert->bindParam(':celulàr_usuario', $usuario->celulàr_usuario);
        $stmInsert->bindParam(':email_usuario', $usuario->email_usuario);
        $stmInsert->bindParam(':login_usuario', $usuario->login_usuario);
        $stmInsert->bindParam(':senha_usuario', $usuario->senha_usuario);
        $stmInsert->bindParam(':cod_perfil', $usuario->cod_perfil);

        $stmInsert->execute();

        $usuario->codUsuario = $conn->lastInsertId();

        return $stmInsert->rowCount() > 0;
    }

    function Update(Usuario &$usuario)
    {
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM tb_usuario WHERE cpf_usuario = :cpf_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cpf_usuario', $usuario->cpf_usuario);
        $stm->execute();

        if($stm->rowCount() > 0)
            throw  new Warning("Usuário já cadastrado!");

        $sqlUpdate = 'UPDATE 
                        tb_usuario 
                      SET 
                        nome_usuario = :nome_usuario, 
                        cpf_usuario = :cpf_usuario, 
                        rg_usuario = :rg_usuario, 
                        telefone_usuario = :telefone_usuario, 
                        celulàr_usuario = :celulàr_usuario, 
                        email_usuario = :email_usuario, 
                        login_usuario = :login_usuario,
                        senha_usuario = :senha_usuario,
                        cod_perfil = :cod_perfil
                      WHERE 
                        cod_usuario = :cod_usuario';

        $stmUpdate = $conn->prepare($sqlUpdate);
        $stmUpdate->bindParam(':nome_usuario', $usuario->nome_usuario);
        $stmUpdate->bindParam(':cpf_usuario', $usuario->cpf_usuario);
        $stmUpdate->bindParam(':rg_usuario', $usuario->rg_usuario);
        $stmUpdate->bindParam(':telefone_usuario', $usuario->telefone_usuario);
        $stmUpdate->bindParam(':celulàr_usuario', $usuario->celulàr_usuario);
        $stmUpdate->bindParam(':email_usuario', $usuario->email_usuario);
        $stmUpdate->bindParam(':login_usuario', $usuario->login_usuario);
        $stmUpdate->bindParam(':senha_usuario', $usuario->senha_usuario);
        $stmUpdate->bindParam(':cod_perfil', $usuario->cod_perfil);

        $stmUpdate->execute();

        return $stmUpdate->rowCount() > 0;
    }

    function Inativa($codUsuario){
        $conn = $this->db->getConnection();

        $sql = "UPDATE tb_usuario SET situacao_usuario = 0 WHERE cod_usuario= :codUsuario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codUsuario', $codUsuario);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function Ativa($codUsuario){
        $conn = $this->db->getConnection();

        $sql = "UPDATE tb_usuario SET situacao_usuario = 1 WHERE cod_usuario= :codUsuario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codUsuario', $codUsuario);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}