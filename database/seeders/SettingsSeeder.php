<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'Plantable Eco', 'type' => 'text', 'group' => 'general', 'sort_order' => 1],
            ['key' => 'site_tagline', 'value' => 'Sustainable Plantable Products for a Greener Tomorrow', 'type' => 'text', 'group' => 'general', 'sort_order' => 2],
            ['key' => 'site_description', 'value' => 'Leading provider of eco-friendly plantable promotional products', 'type' => 'textarea', 'group' => 'general', 'sort_order' => 3],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 4],
            ['key' => 'site_logo_dark', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 5],
            ['key' => 'site_logo_mobile', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 6],
            ['key' => 'site_logo_tablet', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 7],
            ['key' => 'site_favicon', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 8],
            ['key' => 'site_favicon_16', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 9],
            ['key' => 'site_favicon_32', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 10],
            ['key' => 'site_favicon_180', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 11],
            ['key' => 'footer_logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 12],
            ['key' => 'contact_email', 'value' => 'info@plantableeco.com', 'type' => 'text', 'group' => 'general', 'sort_order' => 13],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'general', 'sort_order' => 14],
            ['key' => 'contact_address', 'value' => '123 Eco Street, Green City, EC 12345', 'type' => 'textarea', 'group' => 'general', 'sort_order' => 15],
            ['key' => 'business_hours', 'value' => 'Mon-Fri: 9AM - 6PM', 'type' => 'text', 'group' => 'general', 'sort_order' => 16],
            ['key' => 'currency_symbol', 'value' => '₹', 'type' => 'text', 'group' => 'general', 'sort_order' => 17],
            ['key' => 'currency_code', 'value' => 'INR', 'type' => 'text', 'group' => 'general', 'sort_order' => 18],
            ['key' => 'timezone', 'value' => 'Asia/Kolkata', 'type' => 'text', 'group' => 'general', 'sort_order' => 19],
            ['key' => 'date_format', 'value' => 'd/m/Y', 'type' => 'text', 'group' => 'general', 'sort_order' => 20],

            // Theme Settings
['key' => 'primary_color', 'value' => '#2E7D32', 'type' => 'text', 'group' => 'theme', 'sort_order' => 1],
            ['key' => 'secondary_color', 'value' => '#66BB6A', 'type' => 'text', 'group' => 'theme', 'sort_order' => 2],
            ['key' => 'accent_color', 'value' => '#FFA000', 'type' => 'text', 'group' => 'theme', 'sort_order' => 3],
            ['key' => 'text_color', 'value' => '#333333', 'type' => 'text', 'group' => 'theme', 'sort_order' => 4],
            ['key' => 'heading_font', 'value' => 'Poppins', 'type' => 'text', 'group' => 'theme', 'sort_order' => 5],
            ['key' => 'body_font', 'value' => 'Inter', 'type' => 'text', 'group' => 'theme', 'sort_order' => 6],
            ['key' => 'custom_css', 'value' => '', 'type' => 'textarea', 'group' => 'theme', 'sort_order' => 7],
            ['key' => 'custom_js', 'value' => '', 'type' => 'textarea', 'group' => 'theme', 'sort_order' => 8],

            // SEO Settings
            ['key' => 'meta_title', 'value' => 'Plantable Eco - Sustainable Promotional Products', 'type' => 'text', 'group' => 'seo', 'sort_order' => 1],
            ['key' => 'meta_description', 'value' => 'Discover eco-friendly plantable promotional products that grow into plants', 'type' => 'textarea', 'group' => 'seo', 'sort_order' => 2],
            ['key' => 'meta_keywords', 'value' => 'plantable, eco-friendly, sustainable, promotional products', 'type' => 'textarea', 'group' => 'seo', 'sort_order' => 3],
            ['key' => 'og_image', 'value' => null, 'type' => 'image', 'group' => 'seo', 'sort_order' => 4],
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'seo', 'sort_order' => 5],
            ['key' => 'google_tag_manager_id', 'value' => '', 'type' => 'text', 'group' => 'seo', 'sort_order' => 6],
            ['key' => 'facebook_pixel_id', 'value' => '', 'type' => 'text', 'group' => 'seo', 'sort_order' => 7],
            ['key' => 'custom_head_code', 'value' => '', 'type' => 'textarea', 'group' => 'seo', 'sort_order' => 8],
            ['key' => 'custom_footer_code', 'value' => '', 'type' => 'textarea', 'group' => 'seo', 'sort_order' => 9],

            // Email Settings
            ['key' => 'mail_mailer', 'value' => 'smtp', 'type' => 'text', 'group' => 'email', 'sort_order' => 1],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com', 'type' => 'text', 'group' => 'email', 'sort_order' => 2],
            ['key' => 'mail_port', 'value' => '587', 'type' => 'text', 'group' => 'email', 'sort_order' => 3],
            ['key' => 'mail_username', 'value' => '', 'type' => 'text', 'group' => 'email', 'sort_order' => 4],
            ['key' => 'mail_password', 'value' => '', 'type' => 'password', 'group' => 'email', 'sort_order' => 5],
            ['key' => 'mail_encryption', 'value' => 'tls', 'type' => 'text', 'group' => 'email', 'sort_order' => 6],
            ['key' => 'mail_from_address', 'value' => 'noreply@plantableeco.com', 'type' => 'text', 'group' => 'email', 'sort_order' => 7],
            ['key' => 'mail_from_name', 'value' => 'Plantable Eco', 'type' => 'text', 'group' => 'email', 'sort_order' => 8],
            ['key' => 'email_logo', 'value' => null, 'type' => 'image', 'group' => 'email', 'sort_order' => 9],

            // Payment Settings
            ['key' => 'payment_currency', 'value' => 'INR', 'type' => 'text', 'group' => 'payment', 'sort_order' => 1],
            ['key' => 'razorpay_key', 'value' => '', 'type' => 'text', 'group' => 'payment', 'sort_order' => 2],
            ['key' => 'razorpay_secret', 'value' => '', 'type' => 'password', 'group' => 'payment', 'sort_order' => 3],
            ['key' => 'stripe_key', 'value' => '', 'type' => 'text', 'group' => 'payment', 'sort_order' => 4],
            ['key' => 'stripe_secret', 'value' => '', 'type' => 'password', 'group' => 'payment', 'sort_order' => 5],
            ['key' => 'paypal_client_id', 'value' => '', 'type' => 'text', 'group' => 'payment', 'sort_order' => 6],
            ['key' => 'paypal_secret', 'value' => '', 'type' => 'password', 'group' => 'payment', 'sort_order' => 7],
            ['key' => 'cod_enabled', 'value' => '1', 'type' => 'text', 'group' => 'payment', 'sort_order' => 8],

            // Social Media Settings
            ['key' => 'facebook_url', 'value' => '', 'type' => 'text', 'group' => 'social', 'sort_order' => 1],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'text', 'group' => 'social', 'sort_order' => 2],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'text', 'group' => 'social', 'sort_order' => 3],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'text', 'group' => 'social', 'sort_order' => 4],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'text', 'group' => 'social', 'sort_order' => 5],
            ['key' => 'pinterest_url', 'value' => '', 'type' => 'text', 'group' => 'social', 'sort_order' => 6],
            ['key' => 'whatsapp_number', 'value' => '', 'type' => 'text', 'group' => 'social', 'sort_order' => 7],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
