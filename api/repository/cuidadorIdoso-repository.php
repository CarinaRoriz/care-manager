<?php
require_once "base-repository.php";

class CuidadorIdosoRepository extends BaseRepository
{
    function GetListByIdoso($codIdoso){
        $conn = $this->db->getConnection();

        $sql = "SELECT cod_cuidadorIdoso, i.nome_idoso, u.nome_usuario FROM tb_cuidadorIdoso ci 
                LEFT JOIN tb_idoso i ON (i.cod_idoso = ci.cod_idoso) 
                LEFT JOIN tb_usuario u ON (i.cod_usuario = u.cod_usuario)
                WHERE cod_idoso = :cod_idoso";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cod_idoso', $codIdoso);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(Idoso &$cuidadorIdoso){
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM tb_cuidadoIdoso WHERE cod_idoso = :cod_idoso and cod_usuario = :cod_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cod_idoso', $cuidadorIdoso->cod_idoso);
        $stm->bindParam(':cod_usuario', $cuidadorIdoso->cod_usuario);
        $stm->execute();

        if($stm->rowCount() > 0)
            throw  new Warning("Esse cuidador já está vinculado ao idoso!");

        $sqlInsert = 'INSERT INTO tb_idoso (cod_idoso, cod_usuario) VALUES (:cod_idoso, :cod_usuario)';

        $stmInsert = $conn->prepare($sqlInsert);
        $stmInsert->bindParam(':cod_idoso', $cuidadorIdoso->cod_idoso);
        $stmInsert->bindParam(':cod_usuario', $cuidadorIdoso->cod_usuario);
        $stmInsert->execute();

        $cuidadorIdoso->codCuidadorIdoso = $conn->lastInsertId();

        return $stmInsert->rowCount() > 0;
    }

    function Delete($codCuidadorIdoso)
    {
        $conn = $this->db->getConnection();

        $sql = 'DELETE FROM tb_cuidadorIdoso 
                WHERE cod_cuidadorIdoso = :codCuidadorIdoso';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codCuidadorIdoso', $codCuidadorIdoso);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}