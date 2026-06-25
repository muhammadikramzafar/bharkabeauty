<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query=Order::with('user')->latest();
        if($request->filled('status'))$query->where('status',$request->status);
        if($request->filled('search')){$s=$request->search;$query->where(fn($q)=>$q->where('order_number','like',"%$s%"));}
        $orders=$query->paginate(25)->withQueryString();
        $counts=['all'=>Order::count(),'pending'=>Order::where('status','pending')->count(),'confirmed'=>Order::where('status','confirmed')->count(),'processing'=>Order::where('status','processing')->count(),'shipped'=>Order::where('status','shipped')->count(),'delivered'=>Order::where('status','delivered')->count(),'cancelled'=>Order::where('status','cancelled')->count()];
        return view('admin.orders.index',compact('orders','counts'));
    }
    public function show(Order $order)
    {
        $order->load(['user','items.product']);
        return view('admin.orders.show',compact('order'));
    }
    public function update(Request $request,Order $order)
    {
        $request->validate(['status'=>'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded','payment_status'=>'required|in:unpaid,paid,refunded']);
        $order->update($request->only('status','payment_status'));
        return back()->with('success','Order updated.');
    }
}
