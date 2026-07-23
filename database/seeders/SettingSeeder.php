<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'Plantable Eco Products', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Eco-friendly plantable products for sustainable living', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@plantableeco.com', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+1 234 567 890', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_address', 'value' => '123 Green Street, Eco City, EC 12345', 'type' => 'text', 'group' => 'general'],
            
            // Theme Settings
            ['key' => 'primary_color', 'value' => '#2E7D32', 'type' => 'color', 'group' => 'theme'],
            ['key' => 'secondary_color', 'value' => '#4CAF50', 'type' => 'color', 'group' => 'theme'],
            ['key' => 'accent_color', 'value' => '#8BC34A', 'type' => 'color', 'group' => 'theme'],
            ['key' => 'primary_font', 'value' => 'Poppins', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'secondary_font', 'value' => 'Inter', 'type' => 'text', 'group' => 'theme'],
            
            // SEO Settings
            ['key' => 'seo_meta_title', 'value' => 'Plantable Eco Products - Sustainable Living', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'seo_meta_description', 'value' => 'Discover eco-friendly plantable products that promote sustainable living and environmental consciousness.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'seo_meta_keywords', 'value' => 'plantable, eco-friendly, sustainable, green products, biodegradable', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com', 'type' => 'text', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com', 'type' => 'text', 'group' => 'social'],
            
            // Email Settings
            ['key' => 'mail_from_address', 'value' => 'noreply@plantableeco.com', 'type' => 'text', 'group' => 'email'],
            ['key' => 'mail_from_name', 'value' => 'Plantable Eco Products', 'type' => 'text', 'group' => 'email'],
            
            // Payment Settings
            ['key' => 'stripe_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'payment'],
            ['key' => 'paypal_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'payment'],
            ['key' => 'razorpay_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'payment'],
            ['key' => 'cod_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'payment'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
