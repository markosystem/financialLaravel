<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Balance extends Model
{
    public function deposit(float $valor): Array
    {
        try {
            DB::beginTransaction();
            $totalBefore = $this->amount ? $this->amount : 0;
            $this->amount += number_format($valor, 2, '.', '');
            $deposit = $this->save();

            $historic = auth()->user()->historics()->create([
                'type' => 'I',
                'amount' => $valor,
                'total_before' => $totalBefore,
                'total_after' => $this->amount
            ]);
            if ($deposit && $historic) {
                DB::commit();
                return [
                    'success' => true,
                    'msg' => "Recarga efetuada com sucesso!"
                ];
            }
            DB::rollback();
            return [
                'success' => false,
                'msg' => "Falha ao efetuar a recarga!"
            ];
        } catch (QueryException $e) {
            DB::rollback();
            return [
                'success' => false,
                'msg' => "Falha ao efetuar a recarga!"
            ];
        }
    }

    public function withdrawn(float $valor): Array
    {
        if ($this->amount < $valor) {
            return [
                'success' => false,
                'msg' => 'Saldo insuficiente (R$ ' . number_format($this->amount, 2, '.', '') . ')'
            ];
        }
        try {
            DB::beginTransaction();
            $totalBefore = $this->amount ? $this->amount : 0;
            $this->amount -= number_format($valor, 2, '.', '');
            $withdrawn = $this->save();

            $historic = auth()->user()->historics()->create([
                'type' => 'O',
                'amount' => $valor,
                'total_before' => $totalBefore,
                'total_after' => $this->amount
            ]);
            if ($withdrawn && $historic) {
                DB::commit();
                return [
                    'success' => true,
                    'msg' => "Saque efetuado com sucesso!"
                ];
            }
            DB::rollback();
            return [
                'success' => false,
                'msg' => "Falha ao efetuar o Saque!"
            ];
        } catch (QueryException $e) {
            DB::rollback();
            return [
                'success' => false,
                'msg' => "Falha ao efetuar o Saque!"
            ];
        }
    }

    public function transfer(float $valor, User $sender): Array
    {
        if ($this->amount < $valor) {
            return [
                'success' => false,
                'msg' => 'Saldo insuficiente (R$ ' . number_format($this->amount, 2, '.', '') . ')'
            ];
        }
        try {
            DB::beginTransaction();

            //atualizar saldo do transferidor e historico
            $totalBefore = $this->amount ? $this->amount : 0;
            $this->amount -= number_format($valor, 2, '.', '');
            $transfer = $this->save();

            $historic = auth()->user()->historics()->create([
                'type' => 'T',
                'amount' => $valor,
                'total_before' => $totalBefore,
                'total_after' => $this->amount,
                'user_id_transaction' => $sender->id
            ]);

            //atualiza o saldo do recebedor e historico
            $senderBalance = $sender->balance()->firstOrCreate([]);
            $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
            $senderBalance->amount += number_format($valor, 2, '.', '');
            $transferSender = $senderBalance->save();

            $historicSender = $sender->historics()->create([
                'type' => 'I',
                'amount' => $valor,
                'total_before' => $totalBeforeSender,
                'total_after' => $senderBalance->amount,
                'user_id_transaction' => auth()->user()->id
            ]);


            if ($transfer && $historic && $transferSender && $historicSender) {
                DB::commit();
                return [
                    'success' => true,
                    'msg' => "Transferência realizada com sucesso!"
                ];
            }
            DB::rollback();
            return [
                'success' => false,
                'msg' => "Falha ao efetuar a Transferência!"
            ];
        } catch (QueryException $e) {
            dd($e);
            DB::rollback();
            return [
                'success' => false,
                'msg' => "Falha ao efetuar a Transferência! (Exception)"
            ];
        }
    }
}
