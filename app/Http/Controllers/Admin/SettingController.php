<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.pages.settings.index');
    }

    public function general()
    {
        $settings = $this->getSettingsForGroup('general');
        return view('admin.pages.settings.general', compact('settings'));
    }

    public function theme()
    {
        $settings = $this->getSettingsForGroup('theme');
        return view('admin.pages.settings.theme', compact('settings'));
    }

    public function seo()
    {
        $settings = $this->getSettingsForGroup('seo');
        return view('admin.pages.settings.seo', compact('settings'));
    }

    public function email()
    {
        $settings = $this->getSettingsForGroup('email');
        return view('admin.pages.settings.email', compact('settings'));
    }

    public function payment()
    {
        $settings = $this->getSettingsForGroup('payment');
        return view('admin.pages.settings.payment', compact('settings'));
    }

    public function social()
    {
        $settings = $this->getSettingsForGroup('social');
        return view('admin.pages.settings.social', compact('settings'));
    }

    public function commerce()
    {
        $settings = $this->getSettingsForGroup('commerce');
        
        // Get current values
        $data = [
            'currency_symbol' => Setting::get('currency_symbol', '₹'),
            'currency_code' => Setting::get('currency_code', 'INR'),
            'currency_position' => Setting::get('currency_position', 'before'),
            'default_tax_rate' => Setting::get('default_tax_rate', '0'),
            'default_shipping_charge' => Setting::get('default_shipping_charge', '50'),
            'free_shipping_threshold' => Setting::get('free_shipping_threshold', '1000'),
            'enable_tax' => Setting::get('enable_tax', '1'),
            'enable_shipping' => Setting::get('enable_shipping', '1'),
        ];
        
        return view('admin.pages.settings.commerce', compact('settings', 'data'));
    }

    public function update(Request $request)
    {
        $group = $request->input('group', 'general');
        
        // Handle file uploads for logos and images
        $fileFields = [
            'site_logo', 'site_logo_dark', 'site_logo_mobile', 'site_logo_tablet',
            'site_favicon', 'site_favicon_16', 'site_favicon_32', 'site_favicon_180',
            'og_image', 'footer_logo', 'email_logo', 'invoice_logo'
        ];

        foreach ($request->except(['_token', 'group']) as $key => $value) {
            // Handle file uploads
            if ($request->hasFile($key) && in_array($key, $fileFields)) {
                $file = $request->file($key);
                
                // Delete old file if exists
                $oldSetting = Setting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                    Storage::disk('public')->delete($oldSetting->value);
                }
                
                // Store new file
                $path = $file->store('settings', 'public');
                $value = $path;
            }
            
            // Update or create setting
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $group,
                    'type' => $this->getFieldType($key),
                ]
            );
        }

        Cache::forget('settings');

        return back()->with('success', ucfirst($group) . ' settings updated successfully.');
    }

    private function getSettingsForGroup($group)
    {
        return Setting::where('group', $group)
            ->orderBy('sort_order')
            ->pluck('value', 'key')
            ->toArray();
    }

    private function getFieldType($key)
    {
        $imageFields = [
            'site_logo', 'site_logo_dark', 'site_logo_mobile', 'site_logo_tablet',
            'site_favicon', 'site_favicon_16', 'site_favicon_32', 'site_favicon_180',
            'og_image', 'footer_logo', 'email_logo', 'invoice_logo'
        ];

        $textareaFields = [
            'site_description', 'footer_text', 'meta_description', 'footer_copyright',
            'custom_css', 'custom_js', 'custom_head_code', 'custom_footer_code'
        ];

        if (in_array($key, $imageFields)) {
            return 'image';
        } elseif (in_array($key, $textareaFields)) {
            return 'textarea';
        } else {
            return 'text';
        }
    }
}
