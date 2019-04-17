<?php

namespace App\Http\Controllers\Api;

use App\Update;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function checkUpdate(Request $request)
    {

        $request->validate(
            ['version_code' => 'required']
        );

        $lastUpdate = Update::latest()->first();
        if ($lastUpdate && $request->version_code < $lastUpdate->version_code) {

            return  [
                "new_version_name" => $lastUpdate->version_name,
                "download_link"    => $lastUpdate->link,
                "new_features"     => $lastUpdate->new_features,
                "message"     => '0',
                "new_update"     => 1,
            ];


        } else {
            return [
                "message"     => '0',
                "new_update"     => 0,
            ];
        }
    }
}
