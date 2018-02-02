@extends('adminlte::page')

@section('title','Débosito')

@section('content_header')
    <h1>Confirmar Transferência</h1>
@stop

@section('content')
    <!-- Main content -->
    <div class="box">
        <div class="box-header">
            <h3>Transferência</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')

            <p><strong>Recebedor: </strong>{{ $sender->name }}</p>
            <p><strong>Seu Saldo Atual: </strong>R$ {{ number_format($balance->amount, 2, ',','') }}</p>

            <form method="POST" action="{{ route('transfer.store') }}">
                {!! csrf_field() !!}
                <input type='hidden' name='sender_id' value="{{$sender->id}}"/>
                <div class='form-group'>
                    <input type='text' name='balance' placeholder='Valor:' class='form-control'/>
                </div>
                <div class='form-group'>
                    <button type='submit' class="btn btn-primary"><i class="fa fa-plus"></i>Transferir</button>
                </div>
            </form>
        </div>
    </div>
@stop