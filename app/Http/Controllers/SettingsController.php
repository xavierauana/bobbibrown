<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\UpdateSettingRequest;
use App\Setting;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Setting::class);

        $settings = Setting::all();

        return view('settings.index', compact('settings'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting) {
        $this->authorize('edit', Setting::class);

        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Setting             $setting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request, Setting $setting) {
        $setting->update([
            'label' => $request->get('label'),
            'value' => $request->get('value'),
        ]);

        session()->flash('message', "{$setting->lable} updated!");

        return redirect()->route('settings.index');
    }

}
