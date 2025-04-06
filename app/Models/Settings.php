<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key)
    {
        return self::where('key', $key)->first()?->value ?? null;
    }

    public static function set($key, $value)
    {
        if (auth()->user()->role !== 'super_admin') {
            throw new \Exception('Chỉ Super Admin có thể thay đổi cài đặt hệ thống.');
        }

        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function updateSettings(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Bạn không có quyền thay đổi cài đặt.');
        }

        Setting::set('site_name', $request->site_name);
        Setting::set('maintenance_mode', $request->maintenance_mode);

        return redirect()->back()->with('message', 'Cài đặt đã được cập nhật.');
    }
}
