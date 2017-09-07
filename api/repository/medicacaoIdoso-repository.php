<?php
require_once "base-repository.php";

class MedicacaoIdosoRepository extends BaseRepository
{
    function GetListByIdoso($codIdoso){
        $conn = $this->db->getConnection();

        $sql = "SELECT cod_medicacaoIdoso, descricao_medicacaoIdoso, horario_medicacaoIdoso, ativo_medicacaoIdoso, cod_idoso 
                FROM tb_medicacaoIdoso ci 
                WHERE cod_idoso = :cod_idoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cod_idoso', $codIdoso);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(MedicacaoIdoso &$medicacaoIdoso){
        $conn = $this->db->getConnection();

        $sqlInsert = 'INSERT INTO tb_medicacaoIdoso (descricao_medicacaoIdoso, horario_medicacaoIdoso, ativo_medicacaoIdoso, cod_idoso) 
                      VALUES (:descricao_medicacaoIdoso, :horario_medicacaoIdoso, 1, :cod_idoso)';

        $stmInsert = $conn->prepare($sqlInsert);
        $stmInsert->bindParam(':descricao_medicacaoIdoso', $medicacaoIdoso->descricao_medicacaoIdoso);
        $stmInsert->bindParam(':horario_medicacaoIdoso', $medicacaoIdoso->horario_medicacaoIdoso);
        $stmInsert->bindParam(':cod_idoso', $medicacaoIdoso->cod_idoso);

        $stmInsert->execute();

        $medicacaoIdoso->codMedicacaoIdoso = $conn->lastInsertId();

        return $stmInsert->rowCount() > 0;
    }

    function Inativa($codMedicacaoIdoso){
        $conn = $this->db->getConnection();

        $sql = "UPDATE tb_medicacaoIdoso SET ativo_medicacaoIdoso = 0 WHERE cod_medicacaoIdoso= :codMedicacaoIdoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codMedicacaoIdoso', $codMedicacaoIdoso);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}