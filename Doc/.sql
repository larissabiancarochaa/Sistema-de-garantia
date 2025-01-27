CREATE TABLE tb_usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    cidade VARCHAR(100),
    estado VARCHAR(50), 
    data_nascimento DATE,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    rg VARCHAR(20) UNIQUE NOT NULL,
    endereco VARCHAR(255),
    cep VARCHAR(10),
    telefone VARCHAR(20) UNIQUE NOT NULL,
    estado_civil VARCHAR(50),
    data_hora_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_ultimo_acesso DATETIME
);

CREATE TABLE tb_tipos_acesso (
    id_tipo_acesso INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL
);

CREATE TABLE tb_garantias (
    id_garantia INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    garantia BIGINT NOT NULL UNIQUE,
    nome_revendedor VARCHAR(255),
    data_compra DATE,
    data_instalacao DATE,
    modelo_piscina VARCHAR(255),
    avaliacoes JSON,
    id_usuario_cadastro INT NOT NULL, 
    FOREIGN KEY (id_cliente) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_cadastro) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE tb_logins (
    id_login INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_acesso INT NOT NULL,
    id_usuario INT UNIQUE NOT NULL,
    FOREIGN KEY (id_tipo_acesso) REFERENCES tb_tipos_acesso(id_tipo_acesso) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE
);

INSERT INTO tb_tipos_acesso (descricao) VALUES 
('Administrador do Sistema'),
('Usuário Licenciado'),
('Usuário Desabilitado');