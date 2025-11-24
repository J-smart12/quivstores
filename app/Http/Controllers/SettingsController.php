<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Settings::all();
        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingsRequest $request)
    {
        $settings = Settings::create($request->all());
        return redirect()->route('settings.index')->with('success', 'Settings created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        return view('settings.show', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        return view('settings.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request, Settings $settings)
    {
        $settings->update($request->all());
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        $settings->delete();
        return redirect()->route('settings.index')->with('success', 'Settings deleted successfully');
    }
}
