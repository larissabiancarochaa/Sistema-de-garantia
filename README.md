# Sistema de Garantia

Este é um sistema de gestão de garantias de produtos, permitindo o cadastro de usuários, tipos de acesso e informações relacionadas às garantias de clientes. O sistema permite acompanhar o histórico de garantias, realizando avaliações e gerenciando os dados dos usuários e suas interações com o produto adquirido.

## Estrutura do Banco de Dados

### Tabelas

#### 1. `tb_usuarios`

Tabela que armazena as informações dos usuários do sistema.

```sql

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

```

#### 2. `tb_tipos_acesso`

Tabela que define os tipos de acesso dos usuários.

```sql

CREATE TABLE tb_tipos_acesso (

id_tipo_acesso INT AUTO_INCREMENT PRIMARY KEY,

descricao VARCHAR(100) NOT NULL

);

```

#### 3. `tb_garantias`

Tabela que armazena as informações das garantias de cada cliente, incluindo detalhes sobre o revendedor, datas de compra e instalação, entre outros.

```sql

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

```

#### 4. `tb_logins`

Tabela que armazena os logins dos usuários, relacionando-os aos tipos de acesso.

```sql

CREATE TABLE tb_logins (

id_login INT AUTO_INCREMENT PRIMARY KEY,

id_tipo_acesso INT NOT NULL,

id_usuario INT UNIQUE NOT NULL,

FOREIGN KEY (id_tipo_acesso) REFERENCES tb_tipos_acesso(id_tipo_acesso) ON DELETE CASCADE,

FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE

);

```

### Dados de Exemplo

#### Inserção de Tipos de Acesso

```sql

INSERT INTO tb_tipos_acesso (descricao) VALUES

('Administrador do Sistema'),

('Usuário Licenciado'),

('Usuário Desabilitado');

```

#### Inserção de Usuários

```sql

INSERT INTO tb_usuarios (nome_completo, email, cidade, estado, data_nascimento, cpf, rg, endereco, cep, telefone, estado_civil)

VALUES

('João Silva', 'joao.silva@email.com', 'São Paulo', 'SP', '1985-06-15', '45205736020', '206258963', 'Rua A, 123', '01001-000', '(11) 98765-4321', 'Solteiro'),

('Maria Oliveira', 'maria.oliveira@email.com', 'Rio de Janeiro', 'RJ', '1990-04-22', '98775479028', '300776433', 'Av. B, 456', '20040-002', '(21) 99876-5432', 'Casada'),

('Carlos Mendes', 'carlos.mendes@email.com', 'Belo Horizonte', 'MG', '1988-12-10', '51507504098', '304829109', 'Rua C, 789', '30130-001', '(31) 91234-5678', 'Divorciado');

```

#### Inserção de Garantias

```sql

INSERT INTO `tb_garantias` (`id_garantia`, `id_cliente`, `garantia`, `nome_revendedor`, `data_compra`, `data_instalacao`, `modelo_piscina`, `avaliacoes`, `id_usuario_cadastro`) VALUES

(22, 1, 123464, 'Lucas Revendedor', '2025-01-24', '3333-11-01', 'I9h', '{"atendimento":"Excelente","produto":"Excelente","motivo":"Garantia","origem":"Loja Física","outros":"Tudo perfeito"}', 1),

(23, 2, 123465, 'Mariana Revendedora', '2025-01-25', '3333-12-01', 'J1i', '{"atendimento":"Bom","produto":"Regular","motivo":"Ajuste","origem":"Compra Online","outros":"Precisa de acompanhamento"}', 1),

(24, 3, 123466, 'José Revendedor', '2025-01-26', '3333-12-15', 'K2j', '{"atendimento":"Ótimo","produto":"Bom","motivo":"Troca","origem":"Outros","outros":"Aguardando resposta"}', 1);

```

#### Inserção de Logins

```sql

INSERT INTO tb_logins (id_tipo_acesso, id_usuario)

VALUES

(1, 1),

(2, 2),

(3, 3);

```

## Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para fazer um fork deste repositório e enviar um pull request.