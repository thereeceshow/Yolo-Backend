<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = $request->user();
        $stock = new Stock;
        $stock->user_id = $user->id;
        $stock->ticker_sym = $request->ticker_sym;
        $stock->transaction_price = $request->transaction_price;
        $stock->buy = $request->buy;
        $stock->shares = $request->shares;
            Log::debug("store function line 49");
        if ($stock->buy == 0) { //SELL
            $stocks = $user->stocks()->where('ticker_sym', '=', $stock->ticker_sym)->get();
            $totalStocks = 0;
            Log::debug(count($stocks));
            for ($i = 0; $i < count($stocks); $i++) {
                if ($stocks[$i]->buy == 1) {
                    $totalStocks += $stocks[$i]->shares;
                }
                if ($stocks[$i]->buy == 0) {
                    $totalStocks -= $stocks[$i]->shares;
            }

            if ($totalStocks >= $stock->shares) {
                Log::debug("sell stock " . $stock->ticker_sym);
                $this->sellStock($stock, $user);
            }
        }


        // $stock->save();
        // $user->removeCash(33);
        }

        if ($stock->buy == 1) {
            if ($user->cash >= ($stock->transaction_price * $stock->shares)) {
                Log::debug("buy stock " . $stock->ticker_sym);
            $this->buyStock($stock, $user);
            }
        }

    }

    public function buyStock(&$stock, &$user) {
        $user->cash = $user->cash - ($stock->transaction_price * $stock->shares);
        $stock->save();
        $user->save();
    }

    public function sellStock(&$stock, &$user) {
        $user->cash = $user->cash + ($stock->transaction_price * $stock->shares);
        $stock->save();
        $user->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
