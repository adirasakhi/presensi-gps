<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUserFaceImage()
    {
        $user = Auth::guard('karyawan')->user();

        if ($user) {
            $filePath = public_path('uploads/' . $user->email . '_face.jpg');

            if (file_exists($filePath)) {
                return response()->file($filePath);
            }
        }

        abort(404); // User or face image not found
    }
}

