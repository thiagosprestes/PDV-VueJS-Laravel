@extends('app')

@section('content')
<div class="col-md-4 offset-md-4">
    <div class="card" style="margin-bottom: 10px">
        <div class="card-body">
            <form method="post" action="/login">
                @csrf
                <div class="form-group">
                    <h2 class="text-center">Entrar</h2>
                </div>
                <div class="form-group">
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário">
                </div>                
                <div class="form-group">
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Entrar</button>
                </div>                    
            </form>
        </div>
    </div>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif
</div>
@endsection