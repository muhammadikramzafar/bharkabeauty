<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $query=User::with('roles')->latest();
        if($request->filled('search')){$s=$request->search;$query->where(fn($q)=>$q->where('name','like',"%$s%")->orWhere('email','like',"%$s%"));}
        if($request->filled('role'))$query->whereHas('roles',fn($q)=>$q->where('name',$request->role));
        $users=$query->paginate(25)->withQueryString();
        $roles=Role::orderBy('name')->get();
        return view('admin.users.index',compact('users','roles'));
    }
    public function create(){ $roles=Role::orderBy('name')->get(); return view('admin.users.form',compact('roles')); }
    public function store(Request $request)
    {
        $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','password'=>'required|string|min:8|confirmed','role'=>'required|exists:roles,name']);
        $user=User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>Hash::make($data['password'])]);
        $user->assignRole($data['role']);
        return redirect()->route('admin.users.index')->with('success','User created.');
    }
    public function show(User $user){ return redirect()->route('admin.users.edit',$user); }
    public function edit(User $user){ $roles=Role::orderBy('name')->get(); return view('admin.users.form',compact('user','roles')); }
    public function update(Request $request,User $user)
    {
        $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email,'.$user->id,'password'=>'nullable|string|min:8|confirmed','role'=>'required|exists:roles,name']);
        $user->update(['name'=>$data['name'],'email'=>$data['email'],...(filled($data['password']??null)?['password'=>Hash::make($data['password'])]:[] )]);
        $user->syncRoles([$data['role']]);
        return redirect()->route('admin.users.index')->with('success','User updated.');
    }
    public function destroy(User $user)
    {
        if($user->id===auth()->id())return back()->with('error','You cannot delete your own account.');
        $user->delete();
        return back()->with('success','User deleted.');
    }
}
