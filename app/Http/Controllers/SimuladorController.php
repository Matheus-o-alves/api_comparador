<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimuladorController extends Controller
{
    private $dadosSimulador;
    private $simulacao = [];
          public function simular(Request $request)
{
    try {
        $this->carregarArquivoDadosSimulador()
             ->simularEmprestimo($request->valor_emprestimo)
             ->filtrarInstituicao($request->instituicoes)
             ->filtrarConvenio($request->convenios)
             ->filtrarParcelas($request->parcela);

        $response = [];

        foreach ($this->simulacao as $instituicao => $dados) {
            foreach ($dados as $item) {
                $response[] = [
                    "instituicao"      => $instituicao,
                    "valor_solicitado" => $request->valor_emprestimo,
                    "parcelas_x_valor" => $item['parcelas'] . ' x ' . $item['valor_parcela'],
                    "taxa_juros"       => $item['taxa'] . '% ao mês',
                ];
            }
        }

        if (empty($response)) {
            return response()->json(['message' => 'Nenhum resultado encontrado para os critérios especificados.'], 404);
        }

        return response()->json($response);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
      
    private function carregarArquivoDadosSimulador() : self
    {
        $this->dadosSimulador = json_decode(\File::get(storage_path("app/public/simulador/taxas_instituicoes.json")));
        return $this;
    }

    private function simularEmprestimo(float $valorEmprestimo) : self
    {
        foreach ($this->dadosSimulador as $dados) {
            $this->simulacao[$dados->instituicao][] = [
                "taxa"            => $dados->taxaJuros,
                "parcelas"        => $dados->parcelas,
                "valor_parcela"   => $this->calcularValorDaParcela($valorEmprestimo, $dados->coeficiente),
                "convenio"        => $dados->convenio,
            ];
        }
        return $this;
    }

    private function calcularValorDaParcela(float $valorEmprestimo, float $coeficiente) : float
    {
        return round($valorEmprestimo * $coeficiente, 2);
    }

    private function filtrarConvenio(array $convenios) : self
    {

        \Log::info('Convenios antes da filtragem:', $convenios);

        if (count($convenios) > 0) {
            $this->simulacao = array_map(function ($dados) use ($convenios) {
                return array_filter($dados, function ($item) use ($convenios) {
                    return in_array($item['convenio'], $convenios);
                });
            }, $this->simulacao);
        }
        \Log::info('Resultado após a filtragem:', $this->simulacao);

        return $this;
    }
    private function filtrarParcelas(int $quantidadeParcelas) : self
    {
        if ($quantidadeParcelas > 0) {
            $this->simulacao = array_map(function ($dados) use ($quantidadeParcelas) {
                return array_filter($dados, function ($item) use ($quantidadeParcelas) {
                    return $item['parcelas'] === $quantidadeParcelas;
                });
            }, $this->simulacao);
        }
        return $this;
    }
    private function filtrarInstituicao(array $instituicoes) : self
    {
        if (count($instituicoes) > 0) {
            $this->simulacao = array_filter($this->simulacao, function ($key) use ($instituicoes) {
                return in_array($key, $instituicoes);
            }, ARRAY_FILTER_USE_KEY);
        }
        return $this;
    }
    
}
