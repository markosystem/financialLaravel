@extends('adminlte::page')

@section('title','Débosito')

@section('content_header')
    <h1>Transferir</h1>
@stop

@section('content')
    <!-- Main content -->
    <div class="box">
        <div class="box-header">
            <h3>Realizar Transferência (Informe o recebedor)</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <form method="POST" action="{{ route('confirm.transfer') }}">
                {!! csrf_field() !!}
                <div class='form-group'>
                    <input type='text' name='sender' placeholder='Informe quem receberá a Transferência! (Nome ou E-mail)' class='form-control'/>
                </div>
                <div class='form-group'>
                    <button type='submit' class="btn btn-primary"><i class="fa fa-plus"></i>Próxima Etapa</button>
                </div>
            </form>
        </div>
    </div>
@stop