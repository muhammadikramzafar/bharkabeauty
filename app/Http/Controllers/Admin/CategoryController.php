<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->orderBy('name')->paginate(30);
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.categories.form', compact('parents'));
    }
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:120','slug'=>'nullable|string|max:120|unique:categories,slug','description'=>'nullable|string|max:500','image'=>'nullable|image|max:2048','parent_id'=>'nullable|exists:categories,id','sort_order'=>'integer','is_active'=>'boolean']);
        $data['slug']=$data['slug']?:Str::slug($data['name']);
        $data['is_active']=$request->boolean('is_active',true);
        $data['sort_order']=(int)$request->input('sort_order',0);
        if($request->hasFile('image')) $data['image']=$request->file('image')->store('categories','public');
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success','Category created.');
    }
    public function show(Category $category){ return redirect()->route('admin.categories.edit',$category); }
    public function edit(Category $category)
    {
        $parents=Category::whereNull('parent_id')->where('id','!=',$category->id)->orderBy('name')->get();
        return view('admin.categories.form',compact('category','parents'));
    }
    public function update(Request $request,Category $category)
    {
        $data=$request->validate(['name'=>'required|string|max:120','slug'=>'nullable|string|max:120|unique:categories,slug,'.$category->id,'description'=>'nullable|string|max:500','image'=>'nullable|image|max:2048','parent_id'=>'nullable|exists:categories,id','sort_order'=>'integer','is_active'=>'boolean']);
        $data['is_active']=$request->boolean('is_active',true);
        $data['sort_order']=(int)$request->input('sort_order',0);
        if($request->hasFile('image')){if($category->image)Storage::disk('public')->delete($category->image);$data['image']=$request->file('image')->store('categories','public');}
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success','Category updated.');
    }
    public function destroy(Category $category)
    {
        if($category->image)Storage::disk('public')->delete($category->image);
        $category->delete();
        return back()->with('success','Category deleted.');
    }
}
