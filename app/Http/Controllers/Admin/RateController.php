<?php

namespace App\Http\Controllers\Admin;

use App\Domain\HallGroups\Models\HallGroup;
use App\Domain\Rates\Models\Rate;
use App\Domain\Rates\Requests\RateRequest;
use App\Domain\Rates\Services\RateService;
use App\Http\Controllers\Controller;

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
                ->with('info', trans('admin.first_create_hall_group'));
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

        return redirect()->route('admin.rates.index')->with('success', trans('admin.rate_created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Rate $rate
     * @param RateService $rateService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Rate $rate, RateService $rateService)
    {
        $canChange = $rateService->canChange($rate);
        if(!$canChange) {
            return redirect()->route('admin.rates.index')
                ->with('error', trans('admin.rate_can_not_update'));
        }
        $hallGroups = HallGroup::all();

        return view('admin.rates.edit', compact('rate','hallGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RateRequest $request
     * @param Rate $rate
     * @param RateService $rateService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RateRequest $request, Rate $rate, RateService $rateService)
    {
        $canChange = $rateService->canChange($rate);
        if(!$canChange) {
            return redirect()->route('admin.rates.index')
                ->with('error', trans('admin.rate_can_not_update'));
        }

        $rate->update($request->all());

        return redirect()->route('admin.rates.index')->with('success', trans('admin.rate_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Rate $rate
     * @param RateService $rateService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Rate $rate, RateService $rateService)
    {
        $canChange = $rateService->canChange($rate);
        if(!$canChange) {
            return redirect()->route('admin.rates.index')
                ->with('error', trans('admin.rate_can_not_delete'));
        }

        $rate->delete();

        return redirect()->route('admin.rates.index')->with('success', trans('admin.rate_deleted'));
    }
}
