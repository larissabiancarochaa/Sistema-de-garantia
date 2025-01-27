<?php

namespace Utils;

use Dompdf\Dompdf;

class PDFGenerator
{
    public static function gerarPDF($garantia, $dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $caminhoPDF = $dir . "garantia_original_piscinas_{$garantia['garantia']}.pdf";

        // Conteúdo das três páginas
        $pagina1 = "
            <div style='display: flex; justify-content: center; align-items: center; height: 100vh; font-size: 40px;'>
                <strong>Garantia</strong>
            </div>
        ";

        $pagina2 = "
            <h1>Garantia - Original Piscinas</h1>
            <p><strong>Nome do Cliente:</strong> {$garantia['nome_completo']}</p>
            <p><strong>CPF do Cliente:</strong> {$garantia['cpf']}</p>
            <p><strong>Email:</strong> {$garantia['email']}</p>
            <p><strong>Telefone:</strong> {$garantia['telefone']}</p>
            <p><strong>Cidade:</strong> {$garantia['cidade']}</p>
            <p><strong>Estado:</strong> {$garantia['estado']}</p>
            <p><strong>Data de Nascimento:</strong> {$garantia['data_nascimento']}</p>
            <p><strong>Endereço:</strong> {$garantia['endereco']}</p>
            <p><strong>CEP:</strong> {$garantia['cep']}</p>
            <p><strong>Estado Civil:</strong> {$garantia['estado_civil']}</p>
            <p><strong>Número da Garantia:</strong> {$garantia['garantia']}</p>
            <p><strong>Nome do Revendedor:</strong> {$garantia['nome_revendedor']}</p>
            <p><strong>Data da Compra:</strong> {$garantia['data_compra']}</p>
            <p><strong>Data da Instalação:</strong> {$garantia['data_instalacao']}</p>
            <p><strong>Modelo da Piscina:</strong> {$garantia['modelo_piscina']}</p>
            <h3>Avaliações:</h3>
            <ul>
                <li><strong>Atendimento:</strong> {$garantia['avaliacoes']['atendimento']}</li>
                <li><strong>Produto:</strong> {$garantia['avaliacoes']['produto']}</li>
                <li><strong>Origem:</strong> {$garantia['avaliacoes']['origem']}</li>";

        if (!empty($garantia['avaliacoes']['outros'])) {
            $pagina2 .= "<li><strong>Outros:</strong> {$garantia['avaliacoes']['outros']}</li>";
        }

        $pagina2 .= "</ul>";

        $pagina3 = "
            <div style='display: flex; justify-content: center; align-items: center; height: 100vh; font-size: 40px;'>
                <strong>Logo</strong>
            </div>
        ";

        // Concatenar as páginas
        $conteudoPDF = $pagina1 . "
            <div style='page-break-before: always;'></div>" .
            $pagina2 . "
            <div style='page-break-before: always;'></div>" .
            $pagina3;

        $dompdf = new Dompdf();
        $dompdf->loadHtml($conteudoPDF);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($caminhoPDF, $dompdf->output());
    }
}