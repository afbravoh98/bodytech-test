<?php

namespace App\Http\Controllers;

use App\bodytech\Repositories\ProductRepository;
use App\Http\Requests\ImportProductsRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Imports\ProductsImport;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Exception;

class ProductController extends Controller
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
        try{
            $products = $this->products->all();
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error listando los productos',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success(
            compact('products')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        try{
            $data = $request->validated();
            $product = $this->products->create($data);
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error creando producto',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Producto creado!',
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        try{
            $product = $this->products->findOrFail($id);
            $data = $request->validated();
            $product->update($data);
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Producto no encontrado',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Producto actualizado!',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try{
            $product = $this->products->findOrFail($id);
            $this->products->delete($product);
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Producto no encontrado',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Producto Eliminado!',
        ]);
    }

    /**
     * @param ImportProductsRequest $request
     * @return JsonResponse
     */
    public function import(ImportProductsRequest $request): JsonResponse
    {
        try{
            Excel::import(new ProductsImport(), $request->file('file'));
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error procesando los productos',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Productos importados correctamente!',
        ]);
    }
}
