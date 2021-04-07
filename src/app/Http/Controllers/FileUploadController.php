<?php

namespace Bozboz\Backpack\VisualComposer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    function __construct(Request $request)
    {
        if (!$request->ajax()) {
            return abort(405);
        }
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            response()->json([
                'url' => null,
                'error' => true,
            ]);
        }

        $file = $request->file('file');

        $path_parts = pathinfo($file->getClientOriginalName());
        $filename = $path_parts['filename'] . ' - ' . time() . '.' . $path_parts['extension'];
        $filename = $file->storeAs('public/', $filename );

        $url = Storage::url($filename);

        return response()->json([
            'url' => $url,
            'error' => false,
        ]);
    }
}
