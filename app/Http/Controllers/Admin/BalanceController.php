<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;
        return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->valor);
        if ($response['success'])
            return redirect()
                ->route('admin.balance')
                ->with('success', $response['msg']);

        return redirect()
            ->back()
            ->with('error', $response['msg']);
    }

    public function withdrawn()
    {
        return view('admin.balance.withdrawn');
    }

    public function withdrawnStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdrawn($request->valor);
        if ($response['success'])
            return redirect()
                ->route('admin.balance')
                ->with('success', $response['msg']);

        return redirect()
            ->back()
            ->with('error', $response['msg']);
    }

    public function transfer()
    {
        return view('admin.balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        if (!$sender = $user->getSender($request->sender))
            return redirect()
                ->back()
                ->with('error', 'Usuário informado não foi encontrado!');

        if ($sender->id === auth()->user()->id)
            return redirect()
                ->back()
                ->with('error', 'Não pode transferir para você mesmo!');

        $balance = auth()->user()->balance;

        return view('admin.balance.confirm-transfer', compact('sender', 'balance'));
    }

    public function transferStore(Request $request, User $user)
    {
        if (!$sender = $user->find($request->sender_id))
            return redirect()
                ->route('balance.transfer')
                ->with('error', 'Recebdor não encontrado!');

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->balance, $sender);

        if ($response['success'])
            return redirect()
                ->route('admin.balance')
                ->with('success', $response['msg']);

        return redirect()
            ->route('balance.transfer')
            ->with('error', $response['msg']);
    }

    public function historic()
    {
        $historics = auth()->user()->historics()->with(['userSender'])->get();
        return view('admin.balance.historic', compact('historics'));
    }
}
