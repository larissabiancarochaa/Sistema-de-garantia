<?php
require_once __DIR__ . '/Database.php';

class ListarGarantiaModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getGarantias($filtros = []) {
        $query = "SELECT g.id_garantia, g.garantia, g.nome_revendedor, g.data_compra, 
                         g.modelo_piscina, u.nome_completo, u.cpf, u.rg 
                  FROM tb_garantias g
                  INNER JOIN tb_usuarios u ON g.id_cliente = u.id_usuario";
        $whereClauses = [];
        $params = [];

        if (!empty($filtros['garantia'])) {
            $whereClauses[] = "g.garantia = :garantia";
            $params[':garantia'] = $filtros['garantia'];
        }

        if (!empty($filtros['cpf'])) {
            $whereClauses[] = "u.cpf LIKE :cpf";
            $params[':cpf'] = '%' . preg_replace('/\D/', '', $filtros['cpf']) . '%';
        }

        if (!empty($filtros['rg'])) {
            $whereClauses[] = "u.rg LIKE :rg";
            $params[':rg'] = '%' . $filtros['rg'] . '%';
        }

        if (!empty($filtros['nome'])) {
            $whereClauses[] = "u.nome_completo LIKE :nome";
            $params[':nome'] = '%' . $filtros['nome'] . '%';
        }

        if ($whereClauses) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        } 

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirGarantia($idGarantia) {
        // Busca o número da garantia para saber o nome da pasta
        $query = "SELECT garantia FROM tb_garantias WHERE id_garantia = :id_garantia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_garantia', $idGarantia);
        $stmt->execute();
        $garantia = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($garantia) {
            // Caminho da pasta onde o PDF está armazenado
            $caminhoPdf = __DIR__ . "/../Files/GarantiasGeradas/{$idGarantia}{$garantia['garantia']}";

            // Verifica se a pasta existe
            if (is_dir($caminhoPdf)) {
                // Remove todos os arquivos na pasta
                if (!$this->removerArquivos($caminhoPdf)) {
                    throw new Exception("Erro ao excluir arquivos da garantia {$garantia['garantia']}.");
                }

                // Remove a pasta após excluir os arquivos
                if (!rmdir($caminhoPdf)) {
                    throw new Exception("Erro ao excluir a pasta da garantia {$garantia['garantia']}.");
                }
            } else {
                throw new Exception("A pasta da garantia não foi encontrada.");
            }
        }

        // Exclui a garantia do banco de dados
        $queryDelete = "DELETE FROM tb_garantias WHERE id_garantia = :id_garantia";
        $stmtDelete = $this->conn->prepare($queryDelete);
        $stmtDelete->bindParam(':id_garantia', $idGarantia);
        return $stmtDelete->execute();
    }

    // Função recursiva para remover todos os arquivos e subpastas
    private function removerArquivos($dir) {
        $sucesso = true;

        foreach (glob("{$dir}/*") as $arquivo) {
            if (is_dir($arquivo)) {
                // Se for uma pasta, chama recursivamente
                $sucesso &= $this->removerArquivos($arquivo);
            } else {
                // Se for um arquivo, deleta
                $sucesso &= unlink($arquivo);
            }
        }

        return $sucesso;
    }
}