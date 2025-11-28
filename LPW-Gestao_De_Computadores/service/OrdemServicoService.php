<?php
require_once __DIR__ . '/../model/OrdemServico.php';

class OrdemServicoService
{
    public function validarOrdemServico($ordemServico)
    {
        $erros = [];

        $descricao = trim($ordemServico->getDescricaoProblema());
        if (empty($descricao)) {
            $erros[] = "A descrição do problema é obrigatória.";
        } elseif (strlen($descricao) < 10) {
            $erros[] = "A descrição do problema deve ter pelo menos 10 caracteres.";
        } elseif (strlen($descricao) > 1000) {
            $erros[] = "A descrição do problema deve ter no máximo 1000 caracteres.";
        }

        // fuso horario
        date_default_timezone_set('America/Sao_Paulo');
        
        if (empty($ordemServico->getDataEntrada())) {
            $erros[] = "A data de entrada é obrigatória.";
        } else {
            $dataEntrada = DateTime::createFromFormat('d-m-Y', $ordemServico->getDataEntrada());
            
            if (!$dataEntrada) {
                $dataEntrada = DateTime::createFromFormat('Y-m-d', $ordemServico->getDataEntrada());
            }
            
            if (!$dataEntrada) {
                $erros[] = "A data de entrada '{$ordemServico->getDataEntrada()}' é inválida.";
            } else {
                // fuso horario
                $hoje = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
                $hoje->setTime(0, 0, 0); // Zera a hora para comparar apenas a data
                
                $dataEntrada->setTime(0, 0, 0); 
                
                if ($dataEntrada > $hoje) {
                    $erros[] = "A data de entrada não pode ser futura.";
                }
            }
        }

        if (empty($ordemServico->getPrazoEstimadoSaida())) {
            $erros[] = "O prazo estimado de saída é obrigatório.";
        } else {
            $prazoEstimado = DateTime::createFromFormat('d-m-Y', $ordemServico->getPrazoEstimadoSaida());
            
            if (!$prazoEstimado) {
                $prazoEstimado = DateTime::createFromFormat('Y-m-d', $ordemServico->getPrazoEstimadoSaida());
            }
            
            
            if (isset($dataEntrada) && $prazoEstimado && $dataEntrada) {
                $prazoEstimado->setTime(0, 0, 0);
                $dataEntrada->setTime(0, 0, 0);
                
                if ($prazoEstimado <= $dataEntrada) {
                    $erros[] = "O prazo estimado deve ser posterior à data de entrada.";
                }
            }
        }

        if (empty($ordemServico->getStatus())) {
            $erros[] = "O status é obrigatório.";
        } elseif (!in_array($ordemServico->getStatus(), ['Aberta', 'Em andamento', 'Concluída', 'Cancelada'])) {
            $erros[] = "O status informado é inválido.";
        }

        if ($ordemServico->getCliente() === null) {
            $erros[] = "Cliente é obrigatório.";
        } elseif (!is_numeric($ordemServico->getCliente()->getId()) || $ordemServico->getCliente()->getId() <= 0) {
            $erros[] = "Cliente selecionado é inválido.";
        }

        if ($ordemServico->getTipoServico() === null) {
            $erros[] = "Tipo de serviço é obrigatório.";
        } elseif (!is_numeric($ordemServico->getTipoServico()->getId()) || $ordemServico->getTipoServico()->getId() <= 0) {
            $erros[] = "Tipo de serviço selecionado é inválido.";
        }

        return $erros;
    }
}