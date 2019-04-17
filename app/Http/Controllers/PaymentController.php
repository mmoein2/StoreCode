<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Post;
use App\Utility\SamanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function redirect(Request $request)
    {
        DB::beginTransaction();
        $state = $request->State;
        $res_num = $request->ResNum;
        $ref_num = $request->RefNum;
        $trace_no = $request->TRACENO;
        //$secure_pan = $request->SecurePan;

        $payment = Payment::where('is_used',false)->where('id',$res_num)->first();
        if($payment==null)
        {
            return 'درخواست نا معتبر';
        }

        $payment->state=$state;
        $payment->reference_number=$ref_num;
        $payment->trace_number=$trace_no;
        $payment->is_used=true;

        $message=SamanPayment::getState($state);

        if($state=="OK")
        {
            $soapClient = new \SoapClient('https://sep.shaparak.ir/payments/referencepayment.asmx',array('encoding'=>'UTF-8'));
            $verify_transaction_amount = $soapClient->verifyTransaction($ref_num,env('MID'));

            if($verify_transaction_amount >0)
            {
                if( ((int) $verify_transaction_amount/10) ==$payment->amount)
                {
                    $payment->status=true;

                    $post = $payment->post;
                    $post->is_special=true;
                    $post->save();

                }
                else
                {
                    $soapClient->reverseTransaction($ref_num,env('MID'),env('MID'),env('PID'));
                    $payment->status=false;

                }
            }
            else
            {
                $payment->status=false;
                $message=SamanPayment::getError($verify_transaction_amount);


            }

        }
        else
        {
            $payment->status=false;

        }

        $payment->state=$message;
        $payment->save();

        DB::commit();

        return view('payment.redirect',compact('message','state'));



    }
}
