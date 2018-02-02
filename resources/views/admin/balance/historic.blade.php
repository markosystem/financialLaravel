@extends('adminlte::page')

@section('title','Débosito')

@section('content_header')
    <h1>Histórico</h1>
@stop

@section('content')
    <!-- Main content -->
    <div class="box">
        <div class="box-header">
            <h3>Histórico de Transferência</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>?Sender?</th>
                </tr>
                </thead>
                <tbody>
                @forelse($historics as $historic)
                    <tr>
                        <th>{{$historic->id}}</th>
                        <th>{{'R$ '.number_format($historic->amount, 2, ',', '.')}}</th>
                        <th>{{$historic->type($historic->type)}}</th>
                        <th>{{$historic->created_at}}</th>
                        <th>
                            @if($historic->user_id_transaction)
                                {{$historic->userSender->name}}
                            @else
                                -
                            @endif
                        </th>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop