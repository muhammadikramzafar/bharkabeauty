<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class BrandController extends Controller
{
    public function index()
    {
        $brands=Brand::withCount('products')->orderBy('sort_order')->orderBy('name')->paginate(30);
        return view('admin.brands.index',compact('brands'));
    }
    public function create(){ return view('admin.brands.form'); }
    public function store(Request $request)
    {
        $data=$request->validate(['name'=>'required|string|max:120','slug'=>'nullable|string|max:120|unique:brands,slug','description'=>'nullable|string|max:500','logo'=>'nullable|image|max:2048','website'=>'nullable|url|max:255','is_featured'=>'boolean','is_active'=>'boolean','sort_order'=>'integer']);
        $data['slug']=$data['slug']?:Str::slug($data['name']);
        $data['is_featured']=$request->boolean('is_featured');
        $data['is_active']=$request->boolean('is_active',true);
        $data['sort_order']=(int)$request->input('sort_order',0);
        if($request->hasFile('logo'))$data['logo']=$request->file('logo')->store('brands','public');
        Brand::create($data);
        return redirect()->route('admin.brands.index')->with('success','Brand created.');
    }
    public function show(Brand $brand){ return redirect()->route('admin.brands.edit',$brand); }
    public function edit(Brand $brand){ return view('admin.brands.form',compact('brand')); }
    public function update(Request $request,Brand $brand)
    {
        $data=$request->validate(['name'=>'required|string|max:120','slug'=>'nullable|string|max:120|unique:brands,slug,'.$brand->id,'description'=>'nullable|string|max:500','logo'=>'nullable|image|max:2048','website'=>'nullable|url|max:255','is_featured'=>'boolean','is_active'=>'boolean','sort_order'=>'integer']);
        $data['is_featured']=$request->boolean('is_featured');
        $data['is_active']=$request->boolean('is_active',true);
        $data['sort_order']=(int)$request->input('sort_order',0);
        if($request->hasFile('logo')){if($brand->logo)Storage::disk('public')->delete($brand->logo);$data['logo']=$request->file('logo')->store('brands','public');}
        $brand->update($data);
        return redirect()->route('admin.brands.index')->with('success','Brand updated.');
    }
    public function destroy(Brand $brand)
    {
        if($brand->logo)Storage::disk('public')->delete($brand->logo);
        $brand->delete();
        return back()->with('success','Brand deleted.');
    }
}
