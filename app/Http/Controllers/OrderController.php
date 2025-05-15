<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\StripeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Stripe\Exception\SignatureVerificationException;

class OrderController extends Controller
{
    private StripeService $stripeService;
    private OrderService $orderService;
    private CartService $cartService;

    public function __construct(
        StripeService $stripeService,
        OrderService $orderService,
        CartService $cartService,
    ) {
        $this->stripeService = $stripeService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function success(): \Inertia\Response
    {
        return Inertia::render('Home');
    }

    public function cancel(): \Inertia\Response
    {
        return Inertia::render('Home');
    }

    public function saveOrder(): \Illuminate\Http\RedirectResponse
    {
        try {
            $orderDto = $this->orderService->saveOrderData(Auth::id());
            $session = $this->stripeService->stripeCheckout($orderDto, Auth::user()->email);

            return redirect()->away($session->url);
        } catch (\Exception|DatabaseException $e) {
            Log::error($e->getMessage());
            return redirect()->route('stripe.cancel');
        }
    }

    public function webhook(Request $request): Response
    {
        try {
            $webhookResponse = $this->stripeService->handleWebhooks($request->getContent());
            if (!$webhookResponse->hasResponse()) {
                return new Response('', $webhookResponse->status_code);
            }

            $order = $this->orderService->updateOrder($webhookResponse);

            if ($webhookResponse->paymentSuccessful()) {
                $this->cartService->deleteCartByUser($order->user_id);
                return new Response('', $webhookResponse->status_code);
            }

            return new Response('', $webhookResponse->status_code);
        } catch (SignatureVerificationException $e) {
            Log::error($e->getMessage());
            return new Response('', 401);
        } catch (\Exception|ModelNotFoundException $e) {
            Log::error($e->getMessage());
            return new Response('', 500);
        }
    }
}
