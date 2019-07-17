<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transfer;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('home',compact('user'));
    }

    public function getTransfer()
    {
        return view('transfer');
    }
    public function postTransfer(Request $request)
    {
      $request->validate([
          'email' => 'required|email',
          'saldo' => 'required|numeric',
      ]);

      $penerima=User::where('email','=',$request->email)->first();
      $pengirim=Auth::user();
      if (!$penerima) {
        return redirect()->route('transfer.index')->withStatus('Email Tidak Ditemukan');
      }
      if ($pengirim->email==$penerima->email) {
        return redirect()->route('transfer.index')->withStatus('Anda Tidak Boleh Transfer Ke akun Sendiri');
      }
      if ($pengirim->saldo()<$request->saldo) {
        return redirect()->route('transfer.index')->withStatus('Saldo Tidak Mencukupi');
      }

      $transfer=Transfer::create(['saldo'=>$request->saldo,'penerima_id'=>$penerima->id,'pengirim_id'=>$pengirim->id]);
      if ($transfer) {
        return redirect()->route('home')->withStatus('Transfer Berhasil');
      }
      return redirect()->route('home')->withStatus('Transfer Gagal');
    }

    public function getBalance()
    {
        $user= Auth::user();
        $balance = Transfer::where('penerima_id','=',$user->id)->orWhere('pengirim_id','=',$user->id)->get();
        return view('balance',compact('balance','user'));
    }
}
