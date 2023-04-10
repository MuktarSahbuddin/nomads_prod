<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\TransactionSuccess;

use App\Transaction;
use App\TransactionDetail;
use App\TravlePackage;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail as FacadesMail;

use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index(Request $request, $id){

        $item=Transaction::with(['details', 'travle_packages', 'user'])->findOrFail($id);
        return view('pages.checkout',[
            'item'=>$item
        ]);
    }
    public function process(Request $request, $id){
        $travel_package=TravlePackage::findOrFail($id);

        $transaction=Transaction::create([
            'travle_packages_id' => $id,
            'users_id' => Auth::user()->id,
            'additional_visa' => 0,
            'transaction_total' =>$travel_package->price,
            'transaction_status' => 'IN_CART'
        ]);

        TransactionDetail::create([
            'transactions_id' => $transaction->id,
            'username' => Auth::user()->username,
            'nationality' => 'ID',
            'is_visa' => false,
            'doe_passport' => Carbon::now()->addYears(5)
        ]);

        return redirect()->route('checkout', $transaction->id);



    }
    public function remove(Request $request, $detail_id){
     
        $item=TransactionDetail::findOrFail($detail_id);
        $transaction=Transaction::with(['details', 'travle_packages'])
        ->findOrFail($item->transactions_id);

        if($item->is_visa){
            $transaction->transaction_total -=190;
            $transaction->additional_visa -=190;
           
        }

        $transaction->transaction_total -= $transaction->travle_packages->price;
        $transaction->save();
        $item->delete();

        return redirect()->route('checkout', $item->transactions_id);

    }


    public function create(Request $request, $id){
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'is_visa' => 'required|boolean',
            'doe_passport' => 'required'
        ]);

        $data=$request->all();
        $data['transactions_id'] =$id;

        TransactionDetail::create($data);

        $transaction=Transaction::with(['travle_packages'])->find($id);

        if($request->is_visa){
            $transaction->transaction_total +=190;
            $transaction->additional_visa +=190;
           
        }

        $transaction->transaction_total += $transaction->travle_packages->price;
        $transaction->save();

        return redirect()->route('checkout', $id);

    }



    public function success(Request $request, $id){
        $transaction=Transaction::with(['details', 'travle_packages.galleries',
         'user'])->findOrFail($id);
        $transaction->transaction_status ='PENDING';

        $transaction->save();
       // return $transaction;


       
        //set configurasi midtrans
        Config::$serverKey=config('midtrans.serverKey');
        Config::$isProduction=config('midtrans.isProduction');
        Config::$isSanitized=config('midtrans.isSanitized');
        Config::$is3ds=config('midtrans.is3ds');


        //buat array untuk dikirim ke midtrans
        $midtrans_params=[
            'transaction_details' =>[
                'order_id' => 'TEST-' .$transaction->id,
                'gross_amount' => (int) $transaction->transaction_total
            ],
            'customer_details' =>[
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email
            ],
            'enabled_payments' => ['gopay'],
            'vtweb' => []
        ];


        try {
            //Ambil halaman payment midtrans

            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
            //Redirect ke halaman midtrans
            header('Location: '. $paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();

           
        }

        // //kirim email ke user etiketnya
        // Mail::to($transaction->user)->send(
        //     new TransactionSuccess($transaction)
        // );

        // return view('pages.success');
    }
}
