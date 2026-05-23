<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $phone = File::exists(storage_path('app/settings.json'))
            ? json_decode(File::get(storage_path('app/settings.json')), true)['phone'] ?? '+79991234567'
            : '+79991234567';
        
        return view('admin.settings.index', compact('phone'));
    }

    public function update(Request $request)
    {
        $request->validate(['phone' => 'required']);
        
        File::put(storage_path('app/settings.json'), json_encode(['phone' => $request->phone]));
        
        return redirect()->route('admin.settings.index')->with('success', 'Телефон обновлён');
    }
}