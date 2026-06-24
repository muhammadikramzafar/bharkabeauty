<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaUploadRequest;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaFile::latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $media = $query->paginate(24)->withQueryString();

        return view('admin.media.index', compact('media'));
    }

    public function store(MediaUploadRequest $request)
    {
        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $mime     = $file->getMimeType();
            $type     = MediaFile::typeFromMime($mime);
            $folder   = 'media/' . $type . 's';
            $name     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = Str::slug($name) . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs($folder, $fileName, 'public');

            $uploaded[] = MediaFile::create([
                'name'        => $file->getClientOriginalName(),
                'file_name'   => $fileName,
                'path'        => $path,
                'url'         => Storage::disk('public')->url($path),
                'mime_type'   => $mime,
                'type'        => $type,
                'size'        => $file->getSize(),
                'alt_text'    => $request->alt_text ?? null,
                'disk'        => 'public',
                'uploaded_by' => auth()->id(),
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'files' => $uploaded]);
        }

        return back()->with('success', count($uploaded) . ' file(s) uploaded successfully.');
    }

    public function show(MediaFile $medium)
    {
        return response()->json($medium);
    }

    public function update(Request $request, MediaFile $medium)
    {
        $request->validate(['alt_text' => 'nullable|string|max:255', 'name' => 'required|string|max:255']);
        $medium->update($request->only('name', 'alt_text'));
        return back()->with('success', 'Media updated.');
    }

    public function destroy(MediaFile $medium)
    {
        $medium->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'File deleted.');
    }

    public function create() { return redirect()->route('admin.media.index'); }
    public function edit(MediaFile $medium) { return redirect()->route('admin.media.index'); }
}
