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
                        date_format(data, "%d/%m/%Y") as dias,
                        count(produtos) as produtos,
                        sum(total) as total
                    '))
                    ->groupBy(DB::raw('date_format(data, "%d/%m/%Y")'))
                    ->orderBy(DB::raw('str_to_date(dias, "%d/%m/%Y")'), 'DESC')
                    ->paginate(10);

        return $dados;
    }

    public static function vendasMensais()
    {
        $dados = DB::table('vendas')
                    ->select(DB::raw('
                        date_format(data, "%m/%Y") as meseano,
                        count(produtos) as produtos, 
                        sum(total) as total
                    '))
                    ->groupBy(DB::raw('date_format(data, "%m/%Y")'))
                    ->orderBy('data', 'DESC')
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
