<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$this->group(['middleare' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    $this->get('/', 'AdminController@index')->name('admin.home');
    $this->get('balance', 'BalanceController@index')->name('admin.balance');
    $this->get('deposit', 'BalanceController@deposit')->name('balance.deposit');
    $this->post('deposit', 'BalanceController@depositStore')->name('deposit.store');
    $this->get('withdrawn', 'BalanceController@withdrawn')->name('balance.withdrawn');
    $this->post('withdrawn', 'BalanceController@withdrawnStore')->name('withdrawn.store');

    $this->get('transfer', 'BalanceController@transfer')->name('balance.transfer');
    $this->post('confirm-transfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');
    $this->post('transfer', 'BalanceController@transferStore')->name('transfer.store');
    $this->get('historic', 'BalanceController@historic')->name('admin.historic');
});

$this->get('/', 'Site\SiteController@index');

Auth::routes();