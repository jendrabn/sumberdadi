<?php

namespace App\Http\Controllers\Seller;

use App\DataTables\Seller\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OrderDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('seller.order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $payment = $order->invoice->payments()->first();
        return view('seller.order.show', compact('order', 'payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Order $order
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Order $order)
    {
        $this->validate($request, [
            'tracking_code' => 'required|numeric|unique:shippings,tracking_code'
        ]);

        if (!empty($order->tracking_code)) {
            return redirect()->back()->withError('Perubahan tidak berhasil! Nomor resi sudah disimpan sebelumnya!');
        }

        $order->shipping->update(['status' => Shipping::STATUS_PROCESSING, 'tracking_code' => $request->get('tracking_code')]);
        $order->update(['status' => Order::STATUS_ON_DELIVERY]);

        return redirect()->back()->withSuccess('Nomor resi berhasil disimpan. Sekarang pesanan dalam status pengiriman!');
    }

}
