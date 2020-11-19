<?php

namespace App\Http\Controllers\Admin;

use App\Domain\HallGroups\Models\HallGroup;
use App\Domain\Rates\Models\Rate;
use App\Domain\Rates\Requests\RateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $rates = Rate::with('hallGroup')->get();

        return view('admin.rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $hallGroups = HallGroup::all();
        if($hallGroups->isEmpty()) {
            return redirect()->route('admin.hall-groups.create')
                ->with('info', 'Please, First create Hall group');
        }

        return view('admin.rates.create', compact('hallGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RateRequest $request
     * @param Rate $rate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RateRequest $request, Rate $rate)
    {
        $rate->fill($request->all());
        $rate->save();

        return redirect()->route('admin.rates.index')->with('success', 'Rate created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Rate $rate
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Rate $rate)
    {
        $hallGroups = HallGroup::all();

        return view('admin.rates.edit', compact('rate','hallGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RateRequest $request
     * @param Rate $rate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RateRequest $request, Rate $rate)
    {
        $rate->update($request->all());

        return redirect()->route('admin.rates.index')->with('success', 'Rate updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Rate $rate
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Rate $rate)
    {
        $rate->delete();

        return redirect()->route('admin.rates.index')->with('success', 'Rate deleted');
    }
}
