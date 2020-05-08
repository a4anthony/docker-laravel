<?php

namespace App\Http\Controllers\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Carts\CartRepositoryInterface;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepositoryInterface $cart)
    {
        $this->cart = $cart;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $userId)
    {
        $request->merge(
            [
                'user_id' => (int) $userId
            ]
        );

        $allCartItems = [];
        $arrayProductsInStock = [];
        $arrayProductsNoStock = [];
        $productId = [];

        $allCartItems = $this->cart->getCartItems($request);

        foreach ($allCartItems as $cart) {
            $product = $cart->product;
            if ($product->quantity != 0) {
                $arrayProductsInStock[] = $product;
                $productId[] = $product->id;
            } else {
                $arrayProductsNoStock[] = $product;
            }
        }

        $arrayCart = [
            'allCartItems' => $allCartItems,
            'arrayProductsInStock' => $arrayProductsInStock,
            'arrayProductsNoStock' => $arrayProductsNoStock,
            'productId' => $productId
        ];

        return response()->json(['data' => $arrayCart]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response =  $this->cart->save($request);
        return response()->json(['status' => $response]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId, $productId, $quantity)
    {
        $request->merge(
            [
                'user_id' => (int) $userId
            ]
        );

        $this->cart->updateQuantity($request, $productId, $quantity);
        return response()->json(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $userId, $productId)
    {
        $request->merge(
            [
                'user_id' => (int) $userId
            ]
        );
        $this->cart->deleteCart($request, $productId);
        return response()->json(['status' => true]);
    }
}
