<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $headerMenu = Menu::create(['name' => 'Header Menu', 'location' => 'header', 'status' => true]);
        
        $items = [
            ['title' => 'Home', 'url' => '/', 'icon' => 'fas fa-home', 'sort_order' => 1],
            ['title' => 'About Us', 'url' => '/about-us', 'icon' => 'fas fa-info-circle', 'sort_order' => 2],
            ['title' => 'Products', 'url' => '/products', 'icon' => 'fas fa-box', 'sort_order' => 3],
            ['title' => 'Categories', 'url' => '/categories', 'icon' => 'fas fa-th', 'sort_order' => 4],
            ['title' => 'Blog', 'url' => '/blogs', 'icon' => 'fas fa-blog', 'sort_order' => 5],
            ['title' => 'Contact', 'url' => '/contact-us', 'icon' => 'fas fa-envelope', 'sort_order' => 6],
        ];
        
        foreach ($items as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $headerMenu->id, 'status' => true, 'target' => '_self']));
        }
        
        $footerMenu = Menu::create(['name' => 'Footer Menu', 'location' => 'footer', 'status' => true]);
        
        $footerItems = [
            ['title' => 'Privacy Policy', 'url' => '/privacy-policy', 'sort_order' => 1],
            ['title' => 'Terms & Conditions', 'url' => '/terms-conditions', 'sort_order' => 2],
            ['title' => 'FAQ', 'url' => '/faq', 'sort_order' => 3],
        ];
        
        foreach ($footerItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $footerMenu->id, 'status' => true, 'target' => '_self']));
        }
    }
}
