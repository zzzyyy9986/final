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
        ],
            [
                'description.required' => 'Поля шаблона не должно быть пустым',
                'recommendation.required' => 'Поля шаблона не должно быть пустым',
                'conclusion.required' => 'Поля шаблона не должно быть пустым'
            ]);

        Protocol::create($validated);

        return view("main");
    }
}
