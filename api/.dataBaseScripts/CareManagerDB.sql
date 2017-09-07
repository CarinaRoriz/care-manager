CREATE DATABASE CareManagerDB;

CREATE TABLE `tb_idoso` (
  `cod_idoso` int(11) NOT NULL AUTO_INCREMENT,
  `nome_idoso` varchar(255) NOT NULL,
  `cpf_idoso` varchar(20) NULL,
  `rg_idoso` varchar(20) NULL,
  `dataNascimento_idoso` date NOT NULL,
  `telefone_idoso` varchar(20) NOT NULL,
  `celulàr_idoso` varchar(20) NOT NULL,
  `email_idoso` varchar(20) NOT NULL,
  `situacao_idoso` int NOT NULL,
  PRIMARY KEY (`cod_idoso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tb_usuario` (
  `cod_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(255) NOT NULL,
  `cpf_usuario` varchar(20) NULL,
  `rg_usuario` varchar(20) NULL,
  `telefone_usuario` varchar(20) NOT NULL,
  `celulàr_usuario` varchar(20) NOT NULL,
  `email_usuario` varchar(20) NOT NULL,
  `login_usuario` varchar(50) NOT NULL,
  `senha_usuario` varchar(100) NOT NULL,
  `cod_perfil` int(11) NOT NULL,
  `situacao_usuario` int NOT NULL,
  PRIMARY KEY (`cod_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tb_cuidadorIdoso` (
  `cod_cuidadorIdoso` int(11) NOT NULL auto_increment,
  `cod_idoso` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  PRIMARY KEY (`cod_cuidadorIdoso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE tb_cuidadoridoso
  ADD CONSTRAINT fk_cuidadoridoso_cod_idoso FOREIGN KEY (cod_idoso) REFERENCES tb_idoso (cod_idoso);

ALTER TABLE tb_cuidadoridoso
  ADD CONSTRAINT fk_cuidadoridoso_cod_cuidador FOREIGN KEY (cod_usuario) REFERENCES tb_usuario (cod_usuario);

CREATE TABLE `tb_medicacaoidoso` (
  `cod_medicacaoIdoso` int(11) NOT NULL auto_increment,
  `descricao_medicacaoIdoso` varchar(100) NOT NULL,
  `horario_medicacaoIdoso` TIME NOT NULL,
  `ativo_medicacaoIdoso` BIT NOT NULL,
  `cod_idoso` int(11) NOT NULL,
  PRIMARY KEY (`cod_medicacaoIdoso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE tb_medicacaoidoso
  ADD CONSTRAINT fk_medicacaoidoso_cod_idoso FOREIGN KEY (cod_idoso) REFERENCES tb_idoso (cod_idoso);