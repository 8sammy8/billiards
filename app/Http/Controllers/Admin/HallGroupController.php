<?php

namespace App\Http\Controllers\Admin;

use App\Domain\HallGroups\Models\HallGroup;
use App\Domain\HallGroups\Requests\HallGroupRequest;
use App\Http\Controllers\Controller;

class HallGroupController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $hallGroups = HallGroup::all();

        return view('admin.hall-groups.index', compact('hallGroups'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.hall-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HallGroupRequest $request
     * @param HallGroup $hallGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(HallGroupRequest $request, HallGroup $hallGroup)
    {
        $hallGroup->fill($request->all());
        $hallGroup->save();

        return redirect()->route('admin.hall-groups.index')->with('success', 'Hall group created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HallGroup $hallGroup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(HallGroup $hallGroup)
    {
        return view('admin.hall-groups.edit', compact('hallGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HallGroupRequest $request
     * @param HallGroup $hallGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(HallGroupRequest $request, HallGroup $hallGroup)
    {
        $hallGroup->update($request->all());

        return redirect()->route('admin.hall-groups.index')->with('success', 'Hall group updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HallGroup $hallGroup
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(HallGroup $hallGroup)
    {
        $hallGroup->delete();

        return redirect()->route('admin.hall-groups.index')->with('success', 'Hall group deleted');
    }
}
