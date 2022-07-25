<?php

namespace App\Http\Controllers;

use App\Models\Protocol;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class ProtocolController extends BaseController
{

    public function add(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required',
            'recommendation' => 'required',
            'conclusion' => 'required'
        ]);

        Protocol::create($validated);

        return view("main");
    }
}
