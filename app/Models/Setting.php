<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'is_visible',
        'is_editable',
        'is_required',
        'is_default',
        'default_value',
        'group',
        'category',
        'section',
        'subsection',
        'icon',
        'image',
        'url',
        'color',
        'font',
        'size',
        'style',
        'position',
        'alignment',
        'animation',
        'transition',
        'visibility',
        'access_level',
        'access_group',
        'access_role',
        'access_permission',
    ];

    /**
     * Lấy giá trị của setting theo key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public static function get($key, $default = null)
    {
        // Sử dụng cache để giảm tải truy vấn DB (thời hạn 10 phút)
        return Cache::remember("setting.{$key}", now()->addMinutes(10), function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function boot()
    {
        $settings = Cache::remember('settings.all', now()->addMinutes(10), function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        // Sau đó, bạn có thể set vào config
        config(['settings' => $settings]);
    }

    /**
     * Cập nhật hoặc tạo mới setting.
     *
     * @param string $key
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    public static function set($key, $value)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            throw new \Exception('Chỉ Super Admin có thể thay đổi cài đặt hệ thống.');
        }

        $setting = static::where('key', $key)->first();

        // Nếu setting đã tồn tại và không cho chỉnh sửa
        if ($setting && !$setting->is_editable) {
            throw new \Exception('Cài đặt này không thể chỉnh sửa.');
        }

        Log::info("Setting changed", ['key' => $key, 'value' => $value]);

        $newSetting = static::updateOrCreate(['key' => $key], ['value' => $value]);

        // Làm mới cache cho key này
        Cache::forget("setting.{$key}");
        Cache::put("setting.{$key}", $newSetting->value, now()->addMinutes(10));

        return $newSetting;
    }

    /**
     * Cập nhật nhiều setting từ Request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function updateSettings(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'Bạn không có quyền thay đổi cài đặt.');
        }

        // Lấy các input cần thiết, loại bỏ các trường không mong muốn
        $settings = $request->except(['_token', '_method']);

        foreach ($settings as $key => $value) {
            $setting = static::where('key', $key)->first();

            // Nếu setting tồn tại và không editable, bỏ qua
            if ($setting && !$setting->is_editable) {
                continue;
            }

            static::set($key, $value);
        }

        return redirect()->back()->with('message', 'Cài đặt đã được cập nhật.');
    }
}
