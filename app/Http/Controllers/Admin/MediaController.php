<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\Admin\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(private MediaService $media) {}

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file'],
            'kind' => ['required', 'in:image,document'],
        ]);

        $media = $this->media->upload($request->file('file'), $request->input('kind'));

        return response()->json(['id' => $media->id, 'url' => $media->url], 201);
    }

    public function destroy(Media $media)
    {
        $this->media->delete($media);

        return back()->with('success', 'File deleted.');
    }
}
