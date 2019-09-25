<?php

namespace App\Http\Controllers\Vendas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Venda;

class vendasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaVendas = Venda::orderBy('id', 'DESC')->paginate(10);

        return $listaVendas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();

        $dados['data'] = date('Y-m-d h:m:s');

        if ($dados['recebido'] == '') {
            $dados['recebido'] = '0';
        }

        if ($dados['observacoes'] == '') {
            $dados['observacoes'] = 'Não';
        }

        Venda::create($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dados = $request->all();

        $dados['data'] = date('Y-m-d h:m:s');

        if ($dados['recebido'] == '') {
            $dados['recebido'] = '0';
        }

        if ($dados['observacoes'] == '') {
            $dados['observacoes'] = 'Não';
        }

        Venda::find($id)->update($dados);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Venda::find($id)->delete();
    }

    public function numeroVendas()
    {
        $totalVendas = Venda::numeroVendas();

        return $totalVendas;
    }
}
