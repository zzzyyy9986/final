<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class SampleController extends BaseController
{

    public function index()
    {
        return view("main");
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required',
            'parentId' => 'nullable',
        ]);

        Sample::create($validated);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required',
            'id' => 'required',
        ]);

        Sample::find($validated["id"])->update(["text" => $validated["text"]]);
    }

    public function getSamples()
    {
        return Sample::with("children")
            ->where("parentId", "=", null)
            ->select(["id", "parentId", "text"])
            ->get();
    }

    public function deleteSample($id)
    {
        Sample::find($id)->delete();
    }
}
