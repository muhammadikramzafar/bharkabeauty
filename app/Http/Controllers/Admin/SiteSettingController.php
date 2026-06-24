<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::instance();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(SiteSettingRequest $request)
    {
        $settings = SiteSetting::instance();
        $data = $request->except(['logo', 'favicon', '_token', '_method']);

        if ($request->hasFile('logo')) {
            if ($settings->logo) Storage::disk('public')->delete($settings->logo);
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon) Storage::disk('public')->delete($settings->favicon);
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $settings->update($data);

        return back()->with('success', 'Site settings saved successfully.');
    }
}
