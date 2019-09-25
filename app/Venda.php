<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venda extends Model
{
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'data' => 'date: h:m:s - d/m/Y'
    ];

    protected $fillable = [
        'produtos', 'total', 'cliente', 'pagamento', 'recebido', 'observacoes', 'status', 'data'
    ];

    public static function vendasDiarias()
    {
        $dados = DB::table('vendas')
                    ->select(DB::raw('
                        strftime("%d/%m", data) as dias,
                        count(produtos) as produtos,
                        sum(total) as total
                    '))
                    ->groupBy(DB::raw('strftime("%d/%m", data)'))
                    ->orderBy('dias', 'DESC')
                    ->paginate(10);

        return $dados;
    }

    public static function vendasMensais()
    {
        $dados = DB::table('vendas')
                    ->select(DB::raw('
                        strftime("%m/%Y", data) as meseano,
                        count(produtos) as produtos, 
                        sum(total) as total
                    '))
                    ->groupBy(DB::raw('strftime("%m/%Y", data)'))
                    ->orderBy('meseano', 'DESC')
                    ->paginate(10);

        return $dados;
    }

    public static function numeroVendas()
    {
        $numero = DB::table('vendas')
                    ->select(DB::raw('
                        count(produtos) as produtos
                    '))
                    ->get();

        return $numero;
    }


}
