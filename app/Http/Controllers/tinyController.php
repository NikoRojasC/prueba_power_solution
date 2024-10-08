<?php

namespace App\Http\Controllers;

use App\Services\BracketBalanceService;
use App\Services\TinyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class tinyController extends Controller
{

    protected $tinyService;
    protected $bracketBalanceService;

    public function __construct(TinyService $tinyService, BracketBalanceService $bracketBalanceService)
    {
        $this->tinyService = $tinyService;
        $this->bracketBalanceService = $bracketBalanceService;
    }

    function index()
    {
        return view('shorten');
    }

    function short(Request $request)
    {

        $request->validate([
            'url' => 'required|url'
        ]);

        try {
            $shortUrl = $this->tinyService->shortUrl($request->url);


            return response()->json([
                'original_url' => $request->url,
                'short_url' => $shortUrl['shorturl']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
