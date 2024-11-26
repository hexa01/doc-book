<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use RemoteMerge\Esewa\Client;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Appointment $appointment)
    {
        
    }

    public function esewaPay(Request $request, Appointment $appointment) {
        
        $payment = Payment::where('appointment_id', $appointment->id)->first();
        $pid = uniqid();
        $amount = $payment->amount;

        $payment->pid = $pid;
        $payment->save();

        $successUrl = route('payment.success', );
        $failureUrl = route('payment.failure', );

        $esewa = new Client([
            'merchant_code' => 'EPAYTEST',
            'success_url' => $successUrl,
            'failure_url' => $failureUrl,
        ]);

        $esewa->payment($pid, $amount, 0, 0, 0);
    }

    public function esewaPaySuccess() {
        echo  "success";
        $pid = $_GET['oid'];
        $refid = $_GET['refId'];
        $amount = $_GET['amt'];

        $payment = Payment::where('pid', $pid)->first();

        $payment->status = 'paid';
        $payment->save();
        $appointment = $payment->appointment;
        $appointment->update(
            [
                'status' => 'paid'
                ]
            );
        if($payment->status == 'paid') {
            return redirect()->route('dashboard')->with( 'payment','Payment Successful');
        }

    }

    public function esewaPayFailure() {
        $pid = $_GET['pid'];
        
        $payment = Payment::where('pid', $pid)->first();
        $payment->status = 'unpaid';
        $payment->save();

        if($payment->status == 'unpaid') {
            return redirect()->route('dashboard')->with( 'payment','Payment Failed');
        }
        
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
