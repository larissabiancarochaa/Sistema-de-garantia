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

INSERT INTO tb_usuarios (nome_completo, email, cidade, estado, data_nascimento, cpf, rg, endereco, cep, telefone, estado_civil)
VALUES 
('João Silva', 'joao.silva@email.com', 'São Paulo', 'SP', '1985-06-15', '45205736020', '206258963', 'Rua A, 123', '01001-000', '(11) 98765-4321', 'Solteiro'),
('Maria Oliveira', 'maria.oliveira@email.com', 'Rio de Janeiro', 'RJ', '1990-04-22', '98775479028', '300776433', 'Av. B, 456', '20040-002', '(21) 99876-5432', 'Casada'),
('Carlos Mendes', 'carlos.mendes@email.com', 'Belo Horizonte', 'MG', '1988-12-10', '51507504098', '304829109', 'Rua C, 789', '30130-001', '(31) 91234-5678', 'Divorciado');

INSERT INTO `tb_garantias` (`id_garantia`, `id_cliente`, `garantia`, `nome_revendedor`, `data_compra`, `data_instalacao`, `modelo_piscina`, `avaliacoes`, `id_usuario_cadastro`) VALUES
(22, 1, 123464, 'Lucas Revendedor', '2025-01-24', '3333-11-01', 'I9h', '{\"atendimento\":\"Excelente\",\"produto\":\"Excelente\",\"motivo\":\"Garantia\",\"origem\":\"Loja Física\",\"outros\":\"Tudo perfeito\"}', 1),
(23, 2, 123465, 'Mariana Revendedora', '2025-01-25', '3333-12-01', 'J1i', '{\"atendimento\":\"Bom\",\"produto\":\"Regular\",\"motivo\":\"Ajuste\",\"origem\":\"Compra Online\",\"outros\":\"Precisa de acompanhamento\"}', 1),
(24, 3, 123466, 'José Revendedor', '2025-01-26', '3333-12-15', 'K2j', '{\"atendimento\":\"Ótimo\",\"produto\":\"Bom\",\"motivo\":\"Troca\",\"origem\":\"Outros\",\"outros\":\"Aguardando resposta\"}', 1),
(25, 1, 123467, 'Ana Revendedora', '2025-01-27', '3334-01-10', 'L3k', '{\"atendimento\":\"Regular\",\"produto\":\"Excelente\",\"motivo\":\"Problema técnico\",\"origem\":\"Loja Física\",\"outros\":\"Reforçar orientação\"}', 1),
(26, 2, 123468, 'Carlos Revendedor', '2025-01-28', '3334-01-25', 'M4l', '{\"atendimento\":\"Excelente\",\"produto\":\"Bom\",\"motivo\":\"Dúvida\",\"origem\":\"Loja Física\",\"outros\":\"Gostaria de saber mais\"}', 1),
(27, 3, 123469, 'Juliana Revendedora', '2025-01-29', '3334-02-05', 'N5m', '{\"atendimento\":\"Regular\",\"produto\":\"Bom\",\"motivo\":\"Troca\",\"origem\":\"Compra Online\",\"outros\":\"Produto com defeito\"}', 1),
(28, 1, 123470, 'Felipe Revendedor', '2025-01-30', '3334-02-15', 'O6n', '{\"atendimento\":\"Bom\",\"produto\":\"Regular\",\"motivo\":\"Cancelamento\",\"origem\":\"Loja Física\",\"outros\":\"Produto fora de estoque\"}', 1),
(29, 2, 123471, 'Paula Revendedora', '2025-02-01', '3334-02-20', 'P7o', '{\"atendimento\":\"Ótimo\",\"produto\":\"Excelente\",\"motivo\":\"Devolução\",\"origem\":\"Outros\",\"outros\":\"Fácil processo\"}', 1),
(30, 3, 123472, 'Roberta Revendedora', '2025-02-02', '3334-03-05', 'Q8p', '{\"atendimento\":\"Regular\",\"produto\":\"Bom\",\"motivo\":\"Garantia\",\"origem\":\"Compra Online\",\"outros\":\"Aguardando resposta do fabricante\"}', 1),
(31, 1, 123473, 'Rodrigo Revendedor', '2025-02-03', '3334-03-15', 'R9q', '{\"atendimento\":\"Bom\",\"produto\":\"Excelente\",\"motivo\":\"Troca\",\"origem\":\"Loja Física\",\"outros\":\"Troca feita com sucesso\"}', 1),
(32, 2, 123474, 'Ricardo Revendedor', '2025-02-04', '3334-04-01', 'S0r', '{\"atendimento\":\"Regular\",\"produto\":\"Bom\",\"motivo\":\"Devolução\",\"origem\":\"Compra Online\",\"outros\":\"Aguardando envio\"}', 1),
(33, 3, 123475, 'Letícia Revendedora', '2025-02-05', '3334-04-10', 'T1s', '{\"atendimento\":\"Ótimo\",\"produto\":\"Bom\",\"motivo\":\"Instalação\",\"origem\":\"Loja Física\",\"outros\":\"Excelente suporte\"}', 1),
(34, 1, 123476, 'Marcos Revendedor', '2025-02-06', '3334-04-20', 'U2t', '{\"atendimento\":\"Bom\",\"produto\":\"Regular\",\"motivo\":\"Dúvida\",\"origem\":\"Outros\",\"outros\":\"Preciso de mais detalhes\"}', 1),
(35, 2, 123477, 'Cláudia Revendedora', '2025-02-07', '3334-05-01', 'V3u', '{\"atendimento\":\"Excelente\",\"produto\":\"Bom\",\"motivo\":\"Cancelamento\",\"origem\":\"Loja Física\",\"outros\":\"Cancelamento em andamento\"}', 1),
(36, 3, 123478, 'Eduardo Revendedor', '2025-02-08', '3334-05-15', 'W4v', '{\"atendimento\":\"Bom\",\"produto\":\"Excelente\",\"motivo\":\"Troca\",\"origem\":\"Compra Online\",\"outros\":\"Produto chegou correto\"}', 1),
(37, 1, 123479, 'Lucas Revendedor', '2025-02-09', '3334-05-25', 'X5w', '{\"atendimento\":\"Regular\",\"produto\":\"Bom\",\"motivo\":\"Garantia\",\"origem\":\"Loja Física\",\"outros\":\"Preciso de um reembolso\"}', 1),
(38, 2, 123480, 'Vânia Revendedora', '2025-02-10', '3334-06-01', 'Y6x', '{\"atendimento\":\"Ótimo\",\"produto\":\"Regular\",\"motivo\":\"Problema técnico\",\"origem\":\"Outros\",\"outros\":\"Temos um defeito no produto\"}', 1),
(39, 3, 123481, 'Tatiane Revendedora', '2025-02-11', '3334-06-10', 'Z7y', '{\"atendimento\":\"Bom\",\"produto\":\"Excelente\",\"motivo\":\"Instalação\",\"origem\":\"Loja Física\",\"outros\":\"Ótimo atendimento e produto\"}', 1),
(40, 1, 123482, 'Gustavo Revendedor', '2025-02-12', '3334-06-20', 'A8z', '{\"atendimento\":\"Regular\",\"produto\":\"Bom\",\"motivo\":\"Cancelamento\",\"origem\":\"Loja Física\",\"outros\":\"Pedido cancelado com sucesso\"}', 1);

INSERT INTO tb_logins (id_tipo_acesso, id_usuario)
VALUES 
(1, 1),
(2, 2),
(3, 3);