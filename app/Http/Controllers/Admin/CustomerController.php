<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query=User::withCount('orders')->whereDoesntHave('roles',fn($q)=>$q->whereIn('name',['super-admin','admin','editor']))->latest();
        if($request->filled('search')){$s=$request->search;$query->where(fn($q)=>$q->where('name','like',"%$s%")->orWhere('email','like',"%$s%"));}
        $customers=$query->paginate(25)->withQueryString();
        return view('admin.customers.index',compact('customers'));
    }
    public function show(string $id)
    {
        $customer=User::withCount('orders')->findOrFail($id);
        $orders=Order::where('user_id',$id)->latest()->take(10)->get();
        return view('admin.customers.show',compact('customer','orders'));
    }
}
