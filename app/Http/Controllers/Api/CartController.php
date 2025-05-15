<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): Response
    {
        return Inertia::render('Cart/CartPage');
    }

    public function store(StoreCartRequest $request): CartResource|JsonResponse
    {
        try {
            $stored = $this->cartService->store($request->menu, Auth::id(), $request->quantity);
            return new CartResource($stored);
        } catch (ModelNotFoundException $e) {
            return response()->json([], 404);
        } catch (\Exception|\Throwable $e) {
            Log::error($e->getMessage());
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function list(): ResourceCollection
    {
        $items = $this->cartService->listCartItemsForUser(Auth::id());
        return CartResource::collection($items);
    }
}
