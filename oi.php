<?php
echo "# Sistema de Garantia\n\n";
echo "Este é um sistema de gestão de garantias de produtos, permitindo o cadastro de usuários, tipos de acesso e informações relacionadas às garantias de clientes. O sistema permite acompanhar o histórico de garantias, realizando avaliações e gerenciando os dados dos usuários e suas interações com o produto adquirido.\n\n";

echo "## Estrutura do Banco de Dados\n\n";
echo "### Tabelas\n\n";

echo "#### 1. `tb_usuarios`\n";
echo "Tabela que armazena as informações dos usuários do sistema.\n";
echo "```sql\n";
echo "CREATE TABLE tb_usuarios (\n";
echo "    id_usuario INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "    nome_completo VARCHAR(255) NOT NULL,\n";
echo "    email VARCHAR(255) UNIQUE NOT NULL,\n";
echo "    cidade VARCHAR(100),\n";
echo "    estado VARCHAR(50), \n";
echo "    data_nascimento DATE,\n";
echo "    cpf VARCHAR(14) UNIQUE NOT NULL,\n";
echo "    rg VARCHAR(20) UNIQUE NOT NULL,\n";
echo "    endereco VARCHAR(255),\n";
echo "    cep VARCHAR(10),\n";
echo "    telefone VARCHAR(20) UNIQUE NOT NULL,\n";
echo "    estado_civil VARCHAR(50),\n";
echo "    data_hora_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,\n";
echo "    data_ultimo_acesso DATETIME\n";
echo ");\n";
echo "```\n\n";

echo "#### 2. `tb_tipos_acesso`\n";
echo "Tabela que define os tipos de acesso dos usuários.\n";
echo "```sql\n";
echo "CREATE TABLE tb_tipos_acesso (\n";
echo "    id_tipo_acesso INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "    descricao VARCHAR(100) NOT NULL\n";
echo ");\n";
echo "```\n\n";

echo "#### 3. `tb_garantias`\n";
echo "Tabela que armazena as informações das garantias de cada cliente, incluindo detalhes sobre o revendedor, datas de compra e instalação, entre outros.\n";
echo "```sql\n";
echo "CREATE TABLE tb_garantias (\n";
echo "    id_garantia INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "    id_cliente INT NOT NULL,\n";
echo "    garantia BIGINT NOT NULL UNIQUE,\n";
echo "    nome_revendedor VARCHAR(255),\n";
echo "    data_compra DATE,\n";
echo "    data_instalacao DATE,\n";
echo "    modelo_piscina VARCHAR(255),\n";
echo "    avaliacoes JSON,\n";
echo "    id_usuario_cadastro INT NOT NULL, \n";
echo "    FOREIGN KEY (id_cliente) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE,\n";
echo "    FOREIGN KEY (id_usuario_cadastro) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE\n";
echo ");\n";
echo "```\n\n";

echo "#### 4. `tb_logins`\n";
echo "Tabela que armazena os logins dos usuários, relacionando-os aos tipos de acesso.\n";
echo "```sql\n";
echo "CREATE TABLE tb_logins (\n";
echo "    id_login INT AUTO_INCREMENT PRIMARY KEY,\n";
echo "    id_tipo_acesso INT NOT NULL,\n";
echo "    id_usuario INT UNIQUE NOT NULL,\n";
echo "    FOREIGN KEY (id_tipo_acesso) REFERENCES tb_tipos_acesso(id_tipo_acesso) ON DELETE CASCADE,\n";
echo "    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario) ON DELETE CASCADE\n";
echo ");\n";
echo "```\n\n";

echo "### Dados de Exemplo\n\n";

echo "#### Inserção de Tipos de Acesso\n";
echo "```sql\n";
echo "INSERT INTO tb_tipos_acesso (descricao) VALUES \n";
echo "('Administrador do Sistema'),\n";
echo "('Usuário Licenciado'),\n";
echo "('Usuário Desabilitado');\n";
echo "```\n\n";

echo "#### Inserção de Usuários\n";
echo "```sql\n";
echo "INSERT INTO tb_usuarios (nome_completo, email, cidade, estado, data_nascimento, cpf, rg, endereco, cep, telefone, estado_civil)\n";
echo "VALUES \n";
echo "('João Silva', 'joao.silva@email.com', 'São Paulo', 'SP', '1985-06-15', '45205736020', '206258963', 'Rua A, 123', '01001-000', '(11) 98765-4321', 'Solteiro'),\n";
echo "('Maria Oliveira', 'maria.oliveira@email.com', 'Rio de Janeiro', 'RJ', '1990-04-22', '98775479028', '300776433', 'Av. B, 456', '20040-002', '(21) 99876-5432', 'Casada'),\n";
echo "('Carlos Mendes', 'carlos.mendes@email.com', 'Belo Horizonte', 'MG', '1988-12-10', '51507504098', '304829109', 'Rua C, 789', '30130-001', '(31) 91234-5678', 'Divorciado');\n";
echo "```\n\n";

echo "#### Inserção de Garantias\n";
echo "```sql\n";
echo "INSERT INTO `tb_garantias` (`id_garantia`, `id_cliente`, `garantia`, `nome_revendedor`, `data_compra`, `data_instalacao`, `modelo_piscina`, `avaliacoes`, `id_usuario_cadastro`) VALUES\n";
echo "(22, 1, 123464, 'Lucas Revendedor', '2025-01-24', '3333-11-01', 'I9h', '{\"atendimento\":\"Excelente\",\"produto\":\"Excelente\",\"motivo\":\"Garantia\",\"origem\":\"Loja Física\",\"outros\":\"Tudo perfeito\"}', 1),\n";
echo "(23, 2, 123465, 'Mariana Revendedora', '2025-01-25', '3333-12-01', 'J1i', '{\"atendimento\":\"Bom\",\"produto\":\"Regular\",\"motivo\":\"Ajuste\",\"origem\":\"Compra Online\",\"outros\":\"Precisa de acompanhamento\"}', 1),\n";
echo "(24, 3, 123466, 'José Revendedor', '2025-01-26', '3333-12-15', 'K2j', '{\"atendimento\":\"Ótimo\",\"produto\":\"Bom\",\"motivo\":\"Troca\",\"origem\":\"Outros\",\"outros\":\"Aguardando resposta\"}', 1);\n";
echo "```\n\n";

echo "#### Inserção de Logins\n";
echo "```sql\n";
echo "INSERT INTO tb_logins (id_tipo_acesso, id_usuario)\n";
echo "VALUES \n";
echo "(1, 1),\n";
echo "(2, 2),\n";
echo "(3, 3);\n";
echo "```\n\n";

echo "## Contribuições\n\n";
echo "Contribuições são bem-vindas! Sinta-se à vontade para fazer um fork deste repositório e enviar um pull request.\n";
?>
