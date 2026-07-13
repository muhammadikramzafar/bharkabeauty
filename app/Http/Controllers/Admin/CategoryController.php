<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
    public function toggleVisibility(Category $category)
    {
        $category->update(['is_active' => ! $category->is_active]);
        return back()->with('success', $category->is_active ? 'Category is now visible.' : 'Category is now hidden.');
    }

    public function export(): StreamedResponse
    {
        $categories = Category::with('parent')->orderBy('sort_order')->orderBy('name')->get();

        return response()->streamDownload(function () use ($categories) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'name', 'slug', 'description', 'image', 'parent_slug', 'sort_order', 'is_active']);
            foreach ($categories as $c) {
                fputcsv($handle, [
                    $c->id, $c->name, $c->slug, $c->description,
                    $c->image, $c->parent?->slug, $c->sort_order, $c->is_active ? 1 : 0,
                ]);
            }
            fclose($handle);
        }, 'categories-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
    }

    public function importForm()
    {
        return view('admin.categories.import');
    }

    public function import(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:5120']);

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        $header = array_map(fn ($h) => strtolower(trim($h)), fgetcsv($handle));

        $importDir      = storage_path('app/import/categories');
        $created        = 0;
        $updated        = 0;
        $errors         = [];
        $rowNum         = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }
            $data = array_combine($header, array_pad($row, count($header), null));

            try {
                Validator::make($data, [
                    'name'        => 'required|string|max:120',
                    'slug'        => 'nullable|string|max:120',
                    'description' => 'nullable|string|max:500',
                    'sort_order'  => 'nullable|integer',
                ])->validate();

                $slug = trim((string) ($data['slug'] ?? '')) ?: Str::slug($data['name']);

                $category = null;
                if (! empty($data['id'])) {
                    $category = Category::find($data['id']);
                }
                if (! $category) {
                    $category = Category::where('slug', $slug)->first();
                }

                $slugClash = Category::where('slug', $slug)->when($category, fn ($q) => $q->where('id', '!=', $category->id))->exists();
                if ($slugClash) {
                    throw new \RuntimeException("slug '{$slug}' is already used by another category");
                }

                $parentId = null;
                if (! empty($data['parent_slug'])) {
                    $parent = Category::where('slug', trim($data['parent_slug']))->first();
                    if (! $parent) {
                        throw new \RuntimeException("parent_slug '{$data['parent_slug']}' not found");
                    }
                    $parentId = $parent->id;
                }

                $payload = [
                    'name'        => $data['name'],
                    'slug'        => $slug,
                    'description' => $data['description'] !== '' ? ($data['description'] ?? null) : null,
                    'parent_id'   => $parentId,
                    'sort_order'  => (int) ($data['sort_order'] ?? 0),
                    'is_active'   => filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
                ];

                if (! empty($data['image'])) {
                    $imageValue = trim($data['image']);
                    if (Storage::disk('public')->exists($imageValue)) {
                        $payload['image'] = $imageValue;
                    } else {
                        $sourceFile = $importDir . DIRECTORY_SEPARATOR . basename($imageValue);
                        if (file_exists($sourceFile)) {
                            $ext          = pathinfo($sourceFile, PATHINFO_EXTENSION);
                            $destRelative = 'categories/' . Str::random(20) . ($ext ? ".{$ext}" : '');
                            Storage::disk('public')->put($destRelative, file_get_contents($sourceFile));
                            $payload['image'] = $destRelative;
                        } else {
                            $errors[] = "Row {$rowNum}: image file '{$imageValue}' not found in storage/app/import/categories/";
                        }
                    }
                }

                if ($category) {
                    $category->update($payload);
                    $updated++;
                } else {
                    Category::create($payload);
                    $created++;
                }
            } catch (\Throwable $e) {
                $errors[] = "Row {$rowNum}: " . $e->getMessage();
            }
        }
        fclose($handle);

        return back()->with('import_result', compact('created', 'updated', 'errors'));
    }
}
