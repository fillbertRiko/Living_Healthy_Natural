<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mảng chứa các cài đặt mặc định cho hệ thống
        $defaultSettings = [
            [
                'key'             => 'site_name',
                'value'           => 'Example Site',
                'type'            => 'string',
                'description'     => 'The name of the website.',
                'is_visible'      => true,
                'is_editable'     => true,
                'is_required'     => true,
                'is_default'      => true,
                'default_value'   => 'Example Site',
                'group'           => 'general',
                'category'        => 'site',
                'section'         => 'header',
                'subsection'      => 'branding',
                'icon'            => 'fa-solid fa-globe',
                'image'           => null,
                'url'             => null,
                'color'           => null,
                'font'            => null,
                'size'            => null,
                'style'           => null,
                'position'        => null,
                'alignment'       => null,
                'animation'       => null,
                'transition'      => null,
                'visibility'      => null,
                'access_level'    => null,
                'access_group'    => null,
                'access_role'     => null,
                'access_permission' => null,
            ],
            [
                'key'             => 'site_url',
                'value'           => 'https://www.example.com',
                'type'            => 'string',
                'description'     => 'The official website URL.',
                'is_visible'      => true,
                'is_editable'     => true,
                'is_required'     => true,
                'is_default'      => true,
                'default_value'   => 'https://www.example.com',
                'group'           => 'general',
                'category'        => 'site',
                'section'         => 'footer',
                'subsection'      => null,
                'icon'            => null,
                'image'           => null,
                'url'             => null,
                'color'           => null,
                'font'            => null,
                'size'            => null,
                'style'           => null,
                'position'        => null,
                'alignment'       => null,
                'animation'       => null,
                'transition'      => null,
                'visibility'      => null,
                'access_level'    => null,
                'access_group'    => null,
                'access_role'     => null,
                'access_permission' => null,
            ],
            [
                'key'             => 'contact_email',
                'value'           => 'contact@example.com',
                'type'            => 'string',
                'description'     => 'Email dùng để liên hệ với quản trị viên.',
                'is_visible'      => true,
                'is_editable'     => true,
                'is_required'     => true,
                'is_default'      => true,
                'default_value'   => 'contact@example.com',
                'group'           => 'contact',
                'category'        => 'site',
                'section'         => 'support',
                'subsection'      => null,
                'icon'            => null,
                'image'           => null,
                'url'             => null,
                'color'           => null,
                'font'            => null,
                'size'            => null,
                'style'           => null,
                'position'        => null,
                'alignment'       => null,
                'animation'       => null,
                'transition'      => null,
                'visibility'      => null,
                'access_level'    => null,
                'access_group'    => null,
                'access_role'     => null,
                'access_permission' => null,
            ],
            [
                'key'             => 'maintenance_mode',
                'value'           => '0',  // 0 = off, 1 = on (boolean dạng string)
                'type'            => 'boolean',
                'description'     => 'Bật chế độ bảo trì website.',
                'is_visible'      => false,
                'is_editable'     => true,
                'is_required'     => false,
                'is_default'      => true,
                'default_value'   => '0',
                'group'           => 'system',
                'category'        => 'site',
                'section'         => 'general',
                'subsection'      => null,
                'icon'            => null,
                'image'           => null,
                'url'             => null,
                'color'           => null,
                'font'            => null,
                'size'            => null,
                'style'           => null,
                'position'        => null,
                'alignment'       => null,
                'animation'       => null,
                'transition'      => null,
                'visibility'      => null,
                'access_level'    => null,
                'access_group'    => null,
                'access_role'     => null,
                'access_permission' => null,
            ],
        ];

        foreach ($defaultSettings as $settingData) {
            Setting::create($settingData);
        }
    }
}
