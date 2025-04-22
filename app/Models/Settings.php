<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Settings extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'key', 'value', 'type', 'description',
        'is_visible', 'is_editable', 'is_required',
        'is_default', 'default_value',
        'group', 'category', 'section', 'subsection',
        'icon', 'image', 'url', 'color', 'font', 'size', 'style',
        'position', 'alignment', 'animation', 'transition',
        'visibility', 'access_level', 'access_group', 'access_role', 'access_permission',
    ];

    protected static function boot()
    {
        parent::boot();
        self::loadAllSettingsToConfig();
    }

    protected static function loadAllSettingsToConfig(): void
    {
        $settings = Cache::remember('settings.all', now()->addMinutes(10), function () {
            return self::query()->pluck('value', 'key')->toArray();
        });

        config(['settings' => $settings]);
    }

    public static function get(string $key, $default = null): mixed
    {
        return Cache::remember("setting.{$key}", now()->addMinutes(10), function () use ($key, $default) {
            return self::query()->where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, mixed $value): self
    {
        self::authorizeSettingChange();

        $setting = self::query()->where('key', $key)->first();

        if ($setting && !$setting->is_editable) {
            throw new \Exception("Cài đặt '{$key}' không thể chỉnh sửa.");
        }

        Log::info("Settings changed", ['key' => $key, 'value' => $value]);

        $updated = self::updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::put("setting.{$key}", $updated->value, now()->addMinutes(10));
        Cache::forget('settings.all'); // Làm mới cache toàn bộ nếu cần

        return $updated;
    }

    public static function updateSettings(Request $request)
    {
        self::authorizeSettingChange();

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $setting = self::query()->where('key', $key)->first();

            if ($setting && !$setting->is_editable) {
                continue;
            }

            self::set($key, $value);
        }

        return redirect()->back()->with('message', 'Cài đặt đã được cập nhật.');
    }

    private static function authorizeSettingChange(): void
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'super_admin') {
            throw new \Exception('Chỉ Super Admin có thể thay đổi cài đặt hệ thống.');
        }
    }
}
