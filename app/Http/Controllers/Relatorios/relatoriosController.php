<?php

namespace App\Http\Controllers\Relatorios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Venda;

class relatoriosController extends Controller
{
    public function relatorioMensal()
    {
        $vendasMensais = Venda::vendasMensais();

        return $vendasMensais;
    }

    public function relatorioDiario()
    {
        $vendasDiarias = Venda::vendasDiarias();

        return $vendasDiarias;
    }
}
