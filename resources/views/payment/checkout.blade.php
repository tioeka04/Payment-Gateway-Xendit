<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f4f6f8; display: grid; place-items: center; min-height: 100vh; margin: 0; }
        form { background: #fff; padding: 2rem; border-radius: 12px; width: min(420px, 92vw); box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        label { display: block; margin-top: 1rem; font-size: .9rem; }
        input { width: 100%; padding: .6rem; margin-top: .3rem; border: 1px solid #ccd; border-radius: 6px; box-sizing: border-box; }
        button { margin-top: 1.5rem; width: 100%; padding: .8rem; background: #2563eb; color: #fff; border: 0; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        .err { color: #b91c1c; font-size: .85rem; }
    </style>
</head>
<body>
<form method="POST" action="{{ route('payment.store') }}">
    @csrf
    <h2>Payment Gateway</h2>
    @foreach ($errors->all() as $e)<div class="err">{{ $e }}</div>@endforeach

    <label>Nama <input name="name" value="{{ old('name') }}" required></label>
    <label>Email <input type="email" name="email" value="{{ old('email') }}" required></label>
    <label>Nominal (Rp, min 10.000) <input type="number" name="amount" value="{{ old('amount', 10000) }}" min="10000" required></label>
    <label>Deskripsi <input name="description" value="{{ old('description') }}"></label>

    <button type="submit">Bayar</button>
</form>
</body>
</html>
