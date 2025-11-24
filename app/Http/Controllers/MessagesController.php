<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Http\Requests\StoreMessagesRequest;
use App\Http\Requests\UpdateMessagesRequest;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Messages::all();
        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessagesRequest $request)
    {
        $message = Messages::create($request->all());
        return redirect()->route('messages.index')->with('success', 'Message created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Messages $messages)
    {
        return view('messages.show', compact('messages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Messages $messages)
    {
        return view('messages.edit', compact('messages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessagesRequest $request, Messages $messages)
    {
        $messages->update($request->all());
        return redirect()->route('messages.index')->with('success', 'Message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Messages $messages)
    {
        $messages->delete();
        return redirect()->route('messages.index')->with('success', 'Message deleted successfully');
    }
}
