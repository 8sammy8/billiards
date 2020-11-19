<?php

namespace App\Http\Controllers\Admin;

use App\Domain\HallGroups\Models\HallGroup;
use App\Domain\Tables\Models\Table;
use App\Http\Controllers\Controller;
use App\Domain\Tables\Requests\TableRequest;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tables = Table::with('hallGroup')->get();

        return view('admin.tables.index', compact('tables'));
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

        return view('admin.tables.create', compact('hallGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TableRequest $request
     * @param Table $table
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TableRequest $request, Table $table)
    {
        $this->fill($request, $table)->save();

        return redirect()->route('admin.tables.index')->with('success', 'Table created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Table $table
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Table $table)
    {
        $hallGroups = HallGroup::all();

        return view('admin.tables.edit', compact('table','hallGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TableRequest $request
     * @param Table $table
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TableRequest $request, Table $table)
    {
        $this->fill($request, $table)->update();

        return redirect()->route('admin.tables.index')->with('success', 'Table updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Table $table
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Table deleted');
    }

    /**
     * @param TableRequest $request
     * @param Table $table
     * @return Table
     */
    protected function fill(TableRequest $request, Table $table) :Table
    {
        $table->name            = $request->get('name');
        $table->status          = $request->get('status', Table::TABLE_STATUS_HIDE);
        $table->hall_group_id   = $request->get('hall_group_id');

        return $table;
    }
}
