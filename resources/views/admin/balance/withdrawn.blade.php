@extends('adminlte::page')

@section('title','Débosito')

@section('content_header')
    <h1>Sacar</h1>
@stop

@section('content')
    <!-- Main content -->
    <div class="box">
        <div class="box-header">
            <h3>Realizar Saque</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <form method="POST" action="{{ route('withdrawn.store') }}">
                {!! csrf_field() !!}
                <div class='form-group'>
                    <input type='text' name='valor' placeholder='Valor do Saque' class='form-control'/>
                </div>
                <div class='form-group'>
                    <button type='submit' class="btn btn-primary"><i class="fa fa-plus"></i>Sacar</button>
                </div>
            </form>
        </div>
    </div>
@stop