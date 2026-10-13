<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct(private XenditService $xendit)
    {
    }

    public function index()
    {
        return view('payment.checkout');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'amount' => 'required|integer|min:10000',
            'description' => 'nullable|string|max:200',
        ]);

        $payment = Payment::create([
            'external_id' => 'INV-' . Str::upper(Str::random(10)),
            'name' => $data['name'],
            'email' => $data['email'],
            'amount' => $data['amount'],
            'description' => $data['description'] ?? 'Pembayaran',
            'status' => 'PENDING',
        ]);

        $invoice = $this->xendit->createInvoice([
            'external_id' => $payment->external_id,
            'amount' => $payment->amount,
            'payer_email' => $payment->email,
            'description' => $payment->description,
            'currency' => 'IDR',
            'success_redirect_url' => route('payment.result', $payment->external_id),
            'failure_redirect_url' => route('payment.result', $payment->external_id),
        ]);

        $payment->update([
            'xendit_id' => $invoice['id'],
            'invoice_url' => $invoice['invoice_url'],
        ]);

        return redirect()->away($invoice['invoice_url']);
    }

    public function result(string $externalId)
    {
        $payment = Payment::where('external_id', $externalId)->firstOrFail();

        return view('payment.result', compact('payment'));
    }

    // Dipanggil Xendit (server ke server) saat status invoice berubah.
    public function webhook(Request $request)
    {
        $token = $request->header('x-callback-token');

        if (! $token || ! hash_equals((string) config('services.xendit.callback_token'), $token)) {
            return response()->json(['message' => 'Invalid callback token'], 403);
        }

        $payment = Payment::where('external_id', $request->input('external_id'))->first();

        if ($payment) {
            $payment->update([
                'status' => $request->input('status'),
                'paid_at' => in_array($request->input('status'), ['PAID', 'SETTLED']) ? now() : null,
            ]);
        }

        return response()->json(['message' => 'OK']);
    }

    public function balance()
    {
        return response()->json($this->xendit->getBalance());
    }
}
