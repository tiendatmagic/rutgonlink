<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getLink($website)
    {
        $link = Link::where('website', $website)->first();

        if ($link) {
            return response()->json([
                'success' => true,
                'url' => $link->url
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Link không tồn tại'
        ]);
    }

    public function updateLink(Request $request)
    {
        $website = $request->input('website');
        $url = $request->input('url');
        $password = $request->input('password');

        $link = Link::where('website', $website)->first();

        if ($link) {
            if (!Hash::check($password, $link->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sai mật khẩu'
                ]);
            }
        }

        Link::updateOrCreate(
            ['website' => $website],
            [
                'url' => $url,
                'password' => Hash::make($password)
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lưu link thành công'
        ]);
    }
}
