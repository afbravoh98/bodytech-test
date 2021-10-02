<?php

namespace App\Http\Controllers;

use App\bodytech\Repositories\OrderRepository;
use App\Exports\OrdersExport;
use App\Http\Requests\ExportOrdersRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Exception;

class OrderController extends Controller
{
    private $orders;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orders = $orderRepository;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        try {
            if (\Cart::session($user->id)->isEmpty()){
                return response()->error([
                    'message' => 'El carrito se encuentra vacío.',
                ], HttpResponse::HTTP_FORBIDDEN);
            }
            $total = \Cart::session($user->id)->getTotal();
            /**@var Order $order*/
            $order = $this->orders->create([
                'user_id' => $user->id,
                'status' => 'PAY',
                'total' => $total,
            ]);

            \Cart::session($user->id)->getContent()->each(function($item) use (&$items, &$order) {
                $order->details()->create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                    'product_name' => $item->name,
                    'quantity' => $item->quantity
                ]);
            });

            $order->load('user');
            \Cart::session($user->id)->clear();

        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error pagando la compra.',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Compra realizada con éxito!',
            'order' => $order
        ]);
    }

    public function export(ExportOrdersRequest $request)
    {
        $orders = $this->orders->getBetweenDate($request->get('begin_date'), $request->get('final_date'));
        try{
            return Excel::download(new OrdersExport($orders), 'orders.xlsx');
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error exportando las ordenes',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }
    }
}
