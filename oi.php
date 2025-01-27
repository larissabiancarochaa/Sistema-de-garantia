<?php
echo "# Sistema de Garantia\n\n";
echo "<br> <br>Este é um sistema de gestão de garantias de produtos, permitindo o cadastro de usuários, tipos de acesso e informações relacionadas às garantias de clientes. O sistema permite acompanhar o histórico de garantias, realizando avaliações e gerenciando os dados dos usuários e suas interações com o produto adquirido.\n\n";

echo "<br> <br>## Estrutura do Banco de Dados\n\n";
echo "<br> <br>### Tabelas\n\n";

echo "<br> <br>#### 1. `tb_usuarios`\n";
echo "<br> <br>Tabela que armazena as informações dos usuários do sistema.\n";
echo "<br> <br>```sql\n";
echo "<br> <br>CREATE TABLE tb_usuarios (\n";
echo "<br> <br>    id_usuario INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "<br> <br>    nome_completo VARCHAR(255) NOT NULL,\n";
echo "<br> <br>    email VARCHAR(255) UNIQUE NOT NULL,\n";
echo "<br> <br>    cidade VARCHAR(100),\n";
echo "<br> <br>    estado VARCHAR(50), \n";
echo "<br> <br>    data_nascimento DATE,\n";
echo "<br> <br>    cpf VARCHAR(14) UNIQUE NOT NULL,\n";
echo "<br> <br>    rg VARCHAR(20) UNIQUE NOT NULL,\n";
echo "<br> <br>    endereco VARCHAR(255),\n";
echo "<br> <br>    cep VARCHAR(10),\n";
echo "<br> <br>    telefone VARCHAR(20) UNIQUE NOT NULL,\n";
echo "<br> <br>    estado_civil VARCHAR(50),\n";
echo "<br> <br>    data_hora_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,\n";
echo "<br> <br>    data_ultimo_acesso DATETIME\n";
echo "<br> <br>);\n";
echo "<br> <br>```\n\n";

echo "<br> <br>#### 2. `tb_tipos_acesso`\n";
echo "<br> <br>Tabela que define os tipos de acesso dos usuários.\n";
echo "<br> <br>```sql\n";
echo "<br> <br>CREATE TABLE tb_tipos_acesso (\n";
echo "<br> <br>    id_tipo_acesso INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "<br> <br>    descricao VARCHAR(100) NOT NULL\n";
echo "<br> <br>);\n";
echo "<br> <br>```\n\n";

echo "<br> <br>#### 3. `tb_garantias`\n";
echo "<br> <br>Tabela que armazena as informações das garantias de cada cliente, incluindo detalhes sobre o revendedor, datas de compra e instalação, entre outros.\n";
echo "<br> <br>```sql\n";
echo "<br> <br>CREATE TABLE tb_garantias (\n";
echo "<br> <br>    id_garantia INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "<br> <br>    id_cliente INT NOT NULL,\n";
echo "<br> <br>    garantia BIGINT NOT NULL UNIQUE,\n";
echo "<br> <br>    nome_revendedor VARCHAR(255),\n";
echo "<br> <br>    data_compra DATE,\n";
echo "<br> <br>    data_instalacao DATE,\n";
echo "<br> <br>    modelo_piscina VARCHAR(255),\n";
echo "<br> <br>    avaliacoes JSON,\n";
echo "<br> <br>    id_usuario_cadastro INT NOT NULL, \n";
echo "<br> <br>    FOREIGN KEY (id_cliente) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE,\n";
echo "<br> <br>    FOREIGN KEY (id_usuario_cadastro) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE\n";
echo "<br> <br>);\n";
echo "<br> <br>```\n\n";

echo "<br> <br>#### 4. `tb_logins`\n";
echo "<br> <br>Tabela que armazena os logins dos usuários, relacionando-os aos tipos de acesso.\n";
echo "<br> <br>```sql\n";
echo "<br> <br>CREATE TABLE tb_logins (\n";
echo "<br> <br>    id_login INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "<br> <br>    id_tipo_acesso INT NOT NULL,\n";
echo "<br> <br>    id_usuario INT UNIQUE NOT NULL,\n";
echo "<br> <br>    FOREIGN KEY (id_tipo_acesso) REFERENCES tb_tipos_acesso(id_tipo_acesso) ON DELETE CASCADE,\n";
echo "<br> <br>    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE\n";
echo "<br> <br>);\n";
echo "<br> <br>```\n\n";

echo "<br> <br>### Dados de Exemplo\n\n";

echo "<br> <br>#### Inserção de Tipos de Acesso\n";
echo "<br> <br>```sql\n";
echo "<br> <br>INSERT INTO tb_tipos_acesso (descricao) VALUES \n";
echo "<br> <br>('Administrador do Sistema'),\n";
echo "<br> <br>('Usuário Licenciado'),\n";
echo "<br> <br>('Usuário Desabilitado');\n";
echo "<br> <br>```\n\n";

echo "<br> <br>#### Inserção de Usuários\n";
echo "<br> <br>```sql\n";
echo "<br> <br>INSERT INTO tb_usuarios (nome_completo, email, cidade, estado, data_nascimento, cpf, rg, endereco, cep, telefone, estado_civil)\n";
echo "<br> <br>VALUES \n";
echo "<br> <br>('João Silva', 'joao.silva@email.com', 'São Paulo', 'SP', '1985-06-15', '45205736020', '206258963', 'Rua A, 123', '01001-000', '(11) 98765-4321', 'Solteiro'),\n";
echo "<br> <br>('Maria Oliveira', 'maria.oliveira@email.com', 'Rio de Janeiro', 'RJ', '1990-04-22', '98775479028', '300776433', 'Av. B, 456', '20040-002', '(21) 99876-5432', 'Casada'),\n";
echo "<br> <br>('Carlos Mendes', 'carlos.mendes@email.com', 'Belo Horizonte', 'MG', '1988-12-10', '51507504098', '304829109', 'Rua C, 789', '30130-001', '(31) 91234-5678', 'Divorciado');\n";
echo "<br> <br>```\n\n";

echo "<br> <br>#### Inserção de Garantias\n";
echo "<br> <br>```sql\n";
echo "<br> <br>INSERT INTO `tb_garantias` (`id_garantia`, `id_cliente`, `garantia`, `nome_revendedor`, `data_compra`, `data_instalacao`, `modelo_piscina`, `avaliacoes`, `id_usuario_cadastro`) VALUES\n";
echo "<br> <br>(22, 1, 123464, 'Lucas Revendedor', '2025-01-24', '3333-11-01', 'I9h', '{\"atendimento\":\"Excelente\",\"produto\":\"Excelente\",\"motivo\":\"Garantia\",\"origem\":\"Loja Física\",\"outros\":\"Tudo perfeito\"}', 1),\n";
echo "<br> <br>(23, 2, 123465, 'Mariana Revendedora', '2025-01-25', '3333-12-01', 'J1i', '{\"atendimento\":\"Bom\",\"produto\":\"Regular\",\"motivo\":\"Ajuste\",\"origem\":\"Compra Online\",\"outros\":\"Precisa de acompanhamento\"}', 1),\n";
echo "<br> <br>(24, 3, 123466, 'José Revendedor', '2025-01-26', '3333-12-15', 'K2j', '{\"atendimento\":\"Ótimo\",\"produto\":\"Bom\",\"motivo\":\"Troca\",\"origem\":\"Outros\",\"outros\":\"Aguardando resposta\"}', 1);\n";
echo "<br> <br>```\n\n";

echo "<br> <br>#### Inserção de Logins\n";
echo "<br> <br>```sql\n";
echo "<br> <br>INSERT INTO tb_logins (id_tipo_acesso, id_usuario)\n";
echo "<br> <br>VALUES \n";
echo "<br> <br>(1, 1),\n";
echo "<br> <br>(2, 2),\n";
echo "<br> <br>(3, 3);\n";
echo "<br> <br>```\n\n";

echo "<br> <br>## Contribuições\n\n";
echo "<br> <br>Contribuições são bem-vindas! Sinta-se à vontade para fazer um fork deste repositório e enviar um pull request.\n";
?>
