# PayMint Africa Laravel SDK

The official Laravel wrapper for PayMint Africa. Seamlessly integrate PayMint checkout, virtual accounts, and webhooks into your Laravel application with zero configuration and elegant syntax.

## Installation

Install the package via Composer:

```bash
composer require paymint/paymint-laravel
```

## Configuration

Add your PayMint API keys to your `.env` file:

```env
PAYMINT_SECRET_KEY=sec_live_your_secret_key

# Optional: Set a custom base URL for local testing or staging
# PAYMINT_BASE_URL=https://api.paymint.africa/v1/
```

## Usage

Use the elegant `PayMint` Facade anywhere in your application.

### 1. Hosted Checkout (Start Payment & Verify)

```php
use PayMint\Laravel\Facades\PayMint;

class PaymentController extends Controller
{
    // Step 1: Initialize and redirect customer
    public function initiatePayment(Request $request)
    {
        $response = PayMint::checkout()->initialize([
            'amount'       => 5000,
            'email'        => $request->user()->email,
            'reference'    => 'ORDER_' . uniqid(),
            'redirect_url' => route('payment.callback'),
            'name'         => $request->user()->name,
        ]);

        return redirect($response['data']['authorization_url']);
    }

    // Step 2: Handle customer return & verify
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');
        $payment = PayMint::checkout()->verify($reference);

        if (($payment['data']['status'] ?? '') === 'successful') {
            // Order is paid! Deliver value
            return view('payment.success');
        }

        return view('payment.failed');
    }
}
```

### 2. Dedicated Virtual Accounts

```php
use PayMint\Laravel\Facades\PayMint;

$account = PayMint::virtualAccounts()->create([
    'name'  => 'Jane Doe',
    'email' => 'jane@example.com',
    'phone' => '08123456789'
]);

return response()->json($account);
```

### 3. Webhook Verification

```php
use Illuminate\Http\Request;
use PayMint\Laravel\Facades\PayMint;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/paymint', function (Request $request) {
    $payload = $request->getContent();
    $signature = $request->header('X-Paymint-Signature');

    if (!PayMint::webhooks()->verifySignature($payload, $signature)) {
        return response()->json(['error' => 'Invalid signature detected.'], 401);
    }

    $event = $request->input('event');
    if ($event === 'payment.success') {
        // Credit the customer's wallet or update order status
    }

    return response()->json(['status' => 'success']);
});
```

## License
MIT License
