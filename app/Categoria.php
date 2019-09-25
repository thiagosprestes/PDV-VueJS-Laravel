<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    protected $hidden = [
        'created_at', 'updated_at', 'produtosex'
    ];

    protected $casts = [
        'data' => 'datetime: h:m:s - d/m/Y'
    ];

    protected $fillable = [
        'nome', 'produtosex', 'data'
    ];

    public static function numeroCategorias()
    {
        $numero = DB::table('categorias')
                    ->select(DB::raw('
                        count(nome) as nome
                    '))
                    ->get();

        return $numero;
    }

    public static function nomeCategorias()
    {
        $categoria = DB::table('categorias')->get();

        return $categoria;
    }
}
