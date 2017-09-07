<?php

require_once "base-repository.php";

class IdosoRepository extends BaseRepository
{
    function GetThis($codIdoso){
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM tb_idoso WHERE cod_idoso= :codIdoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codIdoso', $codIdoso);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList(){
        $conn = $this->db->getConnection();

        $sql = "SELECT cod_idoso, nome_idoso, cpf_idoso, rg_idoso, dataNascimento_idoso, telefone_idoso, celulàr_idoso, email_idoso, case situacao_idoso when 1 then 'Ativo' else 'Inativo' end as descricaoSituacao FROM tb_idoso";

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(Idoso &$idoso){
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM tb_idoso WHERE cpf_idoso = :cpf_idoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cpf_idoso', $idoso->cpf_idoso);
        $stm->execute();

        if($stm->rowCount() > 0)
            throw  new Warning("Idoso já cadastrado!");

        $sqlInsert = 'INSERT INTO tb_idoso (nome_idoso, cpf_idoso, rg_idoso, dataNascimento_idoso, telefone_idoso, celulàr_idoso, email_idoso, situacao_idoso) 
                      VALUES (:nome_idoso, :cpf_idoso, :rg_idoso, :dataNascimento_idoso, :telefone_idoso, :celulàr_idoso, :email_idoso, 1)';

        $dataNascimento = DateTime::createFromFormat("d/m/Y", $idoso->datanascimento_idoso);
        $dataNascimento = date_format($dataNascimento, "Y-m-d");

        $stmInsert = $conn->prepare($sqlInsert);
        $stmInsert->bindParam(':nome_idoso', $idoso->nome_idoso);
        $stmInsert->bindParam(':cpf_idoso', $idoso->cpf_idoso);
        $stmInsert->bindParam(':rg_idoso', $idoso->rg_idoso);
        $stmInsert->bindParam(':dataNascimento_idoso', $dataNascimento);
        $stmInsert->bindParam(':telefone_idoso', $idoso->telefone_idoso);
        $stmInsert->bindParam(':celulàr_idoso', $idoso->celulàr_idoso);
        $stmInsert->bindParam(':email_idoso', $idoso->email_idoso);
        $stmInsert->execute();

        $idoso->codIdoso = $conn->lastInsertId();

        return $stmInsert->rowCount() > 0;
    }

    function Update(Idoso &$idoso)
    {
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM tb_idoso WHERE cpf_idoso = :cpf_idoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cpf_idoso', $idoso->cpf_idoso);
        $stm->execute();

        if($stm->rowCount() > 0)
            throw  new Warning("Idoso já cadastrado!");

        $sqlUpdate = 'UPDATE 
                        tb_idoso 
                      SET 
                        nome_idoso = :nome_idoso, 
                        cpf_idoso = :cpf_idoso, 
                        rg_idoso = :rg_idoso, 
                        dataNascimento_idoso = :dataNascimento_idoso, 
                        telefone_idoso = :telefone_idoso, 
                        celulàr_idoso = :celulàr_idoso, 
                        email_idoso = :email_idoso
                      WHERE 
                        cod_idoso = :cod_idoso';

        $dataNascimento = DateTime::createFromFormat("d/m/Y", $idoso->dataNascimento_idoso);
        $dataNascimento = date_format($dataNascimento, "Y-m-d");

        $stmUpdate = $conn->prepare($sqlUpdate);
        $stmUpdate->bindParam(':nome_idoso', $idoso->nome_idoso);
        $stmUpdate->bindParam(':cpf_idoso', $idoso->cpf_idoso);
        $stmUpdate->bindParam(':rg_idoso', $idoso->rg_idoso);
        $stmUpdate->bindParam(':dataNascimento_idoso', $dataNascimento);
        $stmUpdate->bindParam(':telefone_idoso', $idoso->telefone_idoso);
        $stmUpdate->bindParam(':celulàr_idoso', $idoso->celulàr_idoso);
        $stmUpdate->bindParam(':email_idoso', $idoso->email_idoso);
        $stmUpdate->bindParam(':cod_idoso', $idoso->cod_idoso);
        $stmUpdate->execute();

        return $stmUpdate->rowCount() > 0;
    }

    function Inativa($codIdoso){
        $conn = $this->db->getConnection();

        $sql = "UPDATE tb_idoso SET situacao_idoso = 0 WHERE cod_idoso= :codIdoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codIdoso', $codIdoso);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function Ativa($codIdoso){
        $conn = $this->db->getConnection();

        $sql = "UPDATE tb_idoso SET situacao_idoso = 1 WHERE cod_idoso= :codIdoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codIdoso', $codIdoso);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

}
