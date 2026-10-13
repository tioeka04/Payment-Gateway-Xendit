<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pembayaran</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f4f6f8; display: grid; place-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 2rem; border-radius: 12px; width: min(420px, 92vw); box-shadow: 0 4px 20px rgba(0,0,0,.08); text-align: center; }
        .badge { display: inline-block; padding: .3rem .8rem; border-radius: 999px; font-weight: 600; }
        .PAID, .SETTLED { background: #dcfce7; color: #166534; }
        .PENDING { background: #fef9c3; color: #854d0e; }
        .EXPIRED { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
<div class="card">
    <h2>Status Pembayaran</h2>
    <p>{{ $payment->external_id }}</p>
    <p>Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
    <span class="badge {{ $payment->status }}">{{ $payment->status }}</span>

    @if ($payment->status === 'PENDING' && $payment->invoice_url)
        <p><a href="{{ $payment->invoice_url }}">Lanjutkan pembayaran</a></p>
        <p style="font-size:.8rem;color:#666">Status diperbarui otomatis lewat webhook. Refresh halaman ini setelah bayar.</p>
    @endif
    <p><a href="{{ route('payment.index') }}">Kembali</a></p>
</div>
</body>
</html>
