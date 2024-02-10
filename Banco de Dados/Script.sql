
CREATE DATABASE IF NOT EXISTS mypet;

USE mypet;

-- PERFIL
CREATE TABLE IF NOT EXISTS perfil (
 	id_perfil INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	descricao VARCHAR(255) NOT NULL COMMENT 'Descrição dos Perfis',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	dt_inativacao TIMESTAMP COMMENT 'Data de inativação, preenchido = inativo, null = ativo',
	dt_exclusao TIMESTAMP COMMENT 'Data de exclusão, preenchido = excluido, null = não excluido',
	PRIMARY KEY (id_perfil)
) COMMENT='Tabela de Perfis'

INSERT INTO mypet.perfil
(descricao, dt_registro)
VALUES
('Administrador', CURRENT_TIMESTAMP),
('Usuario', CURRENT_TIMESTAMP);

-- USUARIO
CREATE TABLE IF NOT EXISTS usuario (
 	id_usuario INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	nome VARCHAR(255) NOT NULL COMMENT 'Nome do usuário',
	email VARCHAR(255) NOT NULL COMMENT 'E-mail do usuário',
	password VARCHAR(255) NOT NULL COMMENT 'Senha do usuário',
	remember_token VARCHAR(255) NULL COMMENT 'Token do usuário',
	idade TIMESTAMP NOT NULL COMMENT 'Data do nascimento do usuário',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	dt_inativacao TIMESTAMP COMMENT 'Data de inativação, preenchido = inativo, null = ativo',
	qtd_denuncia INT NOT NULL COMMENT 'Quantidade de denúncias recebidas',
	PRIMARY KEY (id_usuario)
) COMMENT='Tabela de Usuários'

-- PERFIL_USUARIO
CREATE TABLE IF NOT EXISTS perfil_usuario (
	id_perfil_usuario INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
 	id_perfil INT NOT NULL COMMENT 'Perfil',
	id_usuario INT NOT NULL COMMENT 'Usuário',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	FOREIGN KEY (id_perfil) REFERENCES perfil(id_perfil),
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
	PRIMARY KEY (id_perfil_usuario)
) COMMENT='Tabela de Perfis_Usuarios'

-- CONTATO
CREATE TABLE IF NOT EXISTS contato (
 	id_contato INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	dd VARCHAR(255) NOT NULL COMMENT 'DD, identificador do estado',
	numero VARCHAR(255) NOT NULL COMMENT 'Numero telefone',
	principal BOOL DEFAULT 1 NOT NULL COMMENT 'Defini se o esse contato e o principal ou não do usuário 0 - Não 1 - Sim',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	id_usuario INT NOT NULL COMMENT 'Usuário do contato',
	PRIMARY KEY (id_contato),
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
) COMMENT='Tabela de Contatos do Usuario'

-- ENDERECO
CREATE TABLE IF NOT EXISTS endereco (
 	id_endereco INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	cep VARCHAR(255) NOT NULL COMMENT 'Cep do endereço',
	bairro VARCHAR(255) NOT NULL COMMENT 'Bairro do endereço',
	numero INT NOT NULL COMMENT 'Numero do endereço',
	complemento VARCHAR(255) NOT NULL COMMENT 'Complemento do endereço',
	principal BOOL DEFAULT 1 NOT NULL COMMENT 'Defini se esse endereço e o principal ou não do usuário 0 - Não 1 - Sim',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	id_usuario INT NOT NULL COMMENT 'Usuário do endereço',
	PRIMARY KEY (id_endereco),
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
) COMMENT='Tabela de Endereço do Usuario'

-- CATEGORIA
CREATE TABLE IF NOT EXISTS categoria_animal (
 	id_categoria INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	descricao VARCHAR(255) NOT NULL COMMENT 'Descrição da Categoria',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	dt_inativacao TIMESTAMP COMMENT 'Data de inativação, preenchido = inativo, null = ativo',
	dt_exclusao TIMESTAMP COMMENT 'Data de exclusão, preenchido = excluido, null = não excluido',
	PRIMARY KEY (id_categoria)
) COMMENT='Tabela de Categorias dos Animais'

INSERT INTO mypet.categoria_animal
(descricao, dt_registro)
VALUES
('Cachorro', CURRENT_TIMESTAMP),
('Gato', CURRENT_TIMESTAMP),
('Passaro', CURRENT_TIMESTAMP),
('Outros', CURRENT_TIMESTAMP);

-- PORTE
CREATE TABLE IF NOT EXISTS porte_animal (
 	id_porte INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	descricao VARCHAR(255) NOT NULL COMMENT 'Descrição do porte',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	dt_inativacao TIMESTAMP COMMENT 'Data de inativação, preenchido = inativo, null = ativo',
	dt_exclusao TIMESTAMP COMMENT 'Data de exclusão, preenchido = excluido, null = não excluido',
	PRIMARY KEY (id_porte)
) COMMENT='Tabela de Porte dos Animais'

INSERT INTO mypet.porte_animal
(descricao, dt_registro)
VALUES
('Pequeno', CURRENT_TIMESTAMP),
('Médio', CURRENT_TIMESTAMP),
('Grande', CURRENT_TIMESTAMP);

-- ANIMAL
CREATE TABLE IF NOT EXISTS animal (
 	id_animal INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
 	nome VARCHAR(255) COMMENT 'Nome do animal, opcional',
	descricao VARCHAR(255) NOT NULL COMMENT 'Descrição do animal',
	idade TIMESTAMP NOT NULL COMMENT 'Data de nascimento do animal',
	sexo CHAR(1) NOT NULL COMMENT 'Sexo do animal',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	dt_inativacao TIMESTAMP COMMENT 'Data de inativação, preenchido = inativo, null = ativo',
	qtd_denuncia INT NOT NULL COMMENT 'Quantidade de denúncias recebidas',
	id_categoria INT NOT NULL COMMENT 'Categoria do animal',
	id_porte INT NOT NULL COMMENT 'Porte do animal',
	id_usuario INT NOT NULL COMMENT 'Usuário responsavel',
	adotado BOOL DEFAULT 1 NOT NULL COMMENT 'Defini se esse o animal foi adotado ou não (Não - 0 Sim - 1)',
	PRIMARY KEY (id_animal),
	FOREIGN KEY (id_categoria) REFERENCES categoria_animal(id_categoria),
	FOREIGN KEY (id_porte) REFERENCES porte_animal(id_porte),
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
) COMMENT='Tabela de Animal'

-- FOTO ANIMAL
CREATE TABLE IF NOT EXISTS foto_animal (
 	id_foto_animal INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
 	nome_arquivo VARCHAR(255) COMMENT 'Nome do arquivo final',
	nome_arquivo_original VARCHAR(255) NOT NULL COMMENT 'Nome do arquivo enviado',
	url VARCHAR(255) NOT NULL COMMENT 'Caminho do arquivo no sistema',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	id_animal INT NOT NULL COMMENT 'Animal',
	PRIMARY KEY (id_foto_animal),
	FOREIGN KEY (id_animal) REFERENCES animal(id_animal)
) COMMENT='Tabela de Fotos dos Animais'

-- FAVORITOS
CREATE TABLE IF NOT EXISTS favorito_animal (
 	id_favorito INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	id_usuario INT NOT NULL COMMENT 'Usuário',
	id_animal INT NOT NULL COMMENT 'Animal',
	PRIMARY KEY (id_favorito),
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
	FOREIGN KEY (id_animal) REFERENCES animal(id_animal)
) COMMENT='Tabela de Animais Favoritos'

-- TIPO DENUNCIA
CREATE TABLE IF NOT EXISTS denuncia_tipo (
 	id_tipo INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	descricao VARCHAR(255) NOT NULL COMMENT 'Descrição do tipo de denuncia',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	dt_inativacao TIMESTAMP COMMENT 'Data de inativação, preenchido = inativo, null = ativo',
	dt_exclusao TIMESTAMP COMMENT 'Data de exclusão, preenchido = excluido, null = não excluido',
	PRIMARY KEY (id_tipo)
) COMMENT='Tabela de tipos de denuncias'

INSERT INTO mypet.denuncia_tipo
(descricao, dt_registro)
VALUES('Maus Tratos', CURRENT_TIMESTAMP),
('Não condiz com a plataforma', CURRENT_TIMESTAMP);

-- DENUNCIA
CREATE TABLE IF NOT EXISTS denuncia (
 	id_denuncia INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	descricao VARCHAR(255) NOT NULL COMMENT 'Descrição da denuncia',
	dt_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro',
	dt_inativacao TIMESTAMP COMMENT 'Data de inativação,caso o usuario inative seu animal, preenchido = inativo, null = ativo',
	dt_exclusao TIMESTAMP COMMENT 'Data de exclusão, preenchido = excluido, null = não excluido',
	id_tipo INT NOT NULL COMMENT 'Tipo de denuncia',
	id_usuario_denunciante INT NOT NULL COMMENT 'Usuário que denunciou',
	id_usuario INT NOT NULL COMMENT 'Usuário denunciado',
	id_animal INT NOT NULL COMMENT 'Animal denunciado',
	PRIMARY KEY (id_denuncia),
	FOREIGN KEY (id_tipo) REFERENCES denuncia_tipo(id_tipo),
	FOREIGN KEY (id_usuario_denunciante) REFERENCES usuario(id_usuario),
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
	FOREIGN KEY (id_animal) REFERENCES animal(id_animal)
) COMMENT='Tabela de denuncias'

-- DENUNCIA RESPOSTA DO ADM
CREATE TABLE IF NOT EXISTS denuncia_resposta (
 	id_resposta INT NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela',
	id_denuncia INT NOT NULL COMMENT 'Chave primaria da denuncia',
	dt_resposta TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Data de registro da resposta',
	aceite BOOL NOT NULL COMMENT 'Defini se foi aceito ou não a denúncia 0 - Não 1 - Sim',
	resposta VARCHAR(100) NOT NULL COMMENT 'Texto de resposta',
	id_usuario INT NOT NULL COMMENT 'Usuario que realizou a resposta',
	PRIMARY KEY (id_resposta),
	FOREIGN KEY (id_denuncia) REFERENCES denuncia(id_denuncia),
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
) COMMENT='Tabela de resposta a denuncias'
