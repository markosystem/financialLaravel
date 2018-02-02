@extends('adminlte::page')

@section('title','Saldo')

@section('content_header')
    <h1>Seu Saldo</h1>
@stop

@section('content')
    <!-- Main content -->
    <div class="box">
        <div class="box-header">
            <a href="{{ route('balance.deposit') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Recarregar</a>
            @if($amount > 0)
                <a href="{{route('balance.withdrawn')}}" class="btn btn-danger"><i class="fa fa-minus-circle"></i> Sacar</a>
            @endif
            @if($amount > 0)
                <a href="{{route('balance.transfer')}}" class="btn btn-info"><i class="fa fa-exchange"></i> Transferir</a>
            @endif
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>R$ {{ number_format($amount, 2, ',','') }}</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="historic" class="small-box-footer">Histórico <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop