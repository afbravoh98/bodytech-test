<?php

namespace App\Http\Controllers;

use App\bodytech\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Exception;

class ShoopingCartController extends Controller
{
    private $products;

    public function __construct(ProductRepository $productRepository)
    {
        $this->products = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $items = [];

        try{

            $total = \Cart::session($user->id)->getTotal();

            \Cart::session($user->id)->getContent()->each(function($item) use (&$items) {
                $items[] = $item;
            });

        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error cargando detalles de el carrito',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'total' => $total,
            'items' => $items,
        ]);

    }

    public function addProduct($id)
    {
        $user = Auth::user();
        try{
            $product = $this->products->findOrFail($id);
            \Cart::session($user->id)->add($product->id, $product->name, $product->price, 1, []);
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error agregando producto.',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Producto agregado!',
            'product' => $product,
        ]);
    }

    public function removeProduct($id)
    {
        $user = Auth::user();
        try{
            $product = $this->products->findOrFail($id);
            \Cart::session($user->id)->remove($product->id);
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error removiendo producto.',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => "Producto $product->name removido!",
            'product' => $product,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }
}
