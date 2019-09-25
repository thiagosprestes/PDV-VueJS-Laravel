<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produto extends Model
{
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'data' => 'date: h:m:s - d/m/y'
    ];

    protected $fillable = [
        'codigo', 'nome', 'qtd', 'valor', 'categoria', 'data'
    ];

    public static function registrarVendaProduto($codigo)
    {
        $produto = DB::table('produtos')->where('codigo', '=', $codigo)->get();

        return $produto;
    }

    public static function numeroProdutos()
    {
        $numero = DB::table('produtos')
                    ->select(DB::raw('
                        count(codigo) as codigo
                    '))
                    ->get();
                    
        return $numero;
    }
}
