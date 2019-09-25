<?php

namespace App\Http\Controllers\Produtos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produto;

class produtosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaProdutos = Produto::orderBy('id', 'DESC')->paginate(10);

        return $listaProdutos;
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

        $dados['valor'] = str_replace(',', '.', $dados['valor']);
        $dados['data'] = date('Y-m-d H:m:s');

        $mensagens = [
            'codigo.unique' => 'Já existe um produto cadastrado com este código de barras.',
        ];

        $request->validate([
            'codigo' => 'required|unique:produtos',
            'nome' => 'required',
            'qtd' => 'required|integer',
            'valor' => 'required',
            'categoria' => 'required'
        ], $mensagens);

        Produto::create($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($codigo)
    {
        $produto = Produto::registrarVendaProduto($codigo);

        return $produto;
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

        $dados['valor'] = str_replace(',', '.', $dados['valor']);
        $dados['data'] = date('Y-m-d H:m:s');

        $mensagens = [
            'codigo.unique' => 'Já existe um produto cadastrado com este código de barras.',
        ];

        $request->validate([
            'codigo' => 'required|unique:produtos,codigo,'.$request->id,
            'nome' => 'required',
            'qtd' => 'required|integer',
            'valor' => 'required',
            'categoria' => 'required'
        ], $mensagens);

        Produto::find($id)->update($dados);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Produto::find($id);
        $dados->delete();
    }

    public function numeroProdutos()
    {
        $totalProdutos = Produto::numeroProdutos();

        return $totalProdutos;
    }
}
