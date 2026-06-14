<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserPoint;
use App\Models\B2bProfile;
use App\Models\ImpactMetric;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@kalafabrics.id'],
            [
                'name'     => 'Admin KalaFabrics',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );
        UserPoint::firstOrCreate(['user_id' => $admin->id], [
            'total_points' => 0,
            'redeemed_points' => 0,
            'available_points' => 0,
        ]);

        // Create B2C Member
        $b2c = User::firstOrCreate(
            ['email' => 'member@kalafabrics.id'],
            [
                'name'     => 'Demo B2C Member',
                'password' => Hash::make('password'),
                'role'     => 'b2c',
            ]
        );
        UserPoint::firstOrCreate(['user_id' => $b2c->id], [
            'total_points' => 100,
            'redeemed_points' => 10,
            'available_points' => 90,
        ]);

        // Create B2B Partner
        $b2b = User::firstOrCreate(
            ['email' => 'partner@kalafabrics.id'],
            [
                'name'     => 'Demo B2B Partner',
                'password' => Hash::make('password'),
                'role'     => 'b2b',
            ]
        );
        UserPoint::firstOrCreate(['user_id' => $b2b->id], [
            'total_points' => 500,
            'redeemed_points' => 50,
            'available_points' => 450,
        ]);
        B2bProfile::firstOrCreate(['user_id' => $b2b->id], [
            'company_name' => 'PT Tekstil Ramah Lingkungan',
            'company_registration_number' => 'REG-001',
            'company_address' => 'Jl. Industri No. 123, Jakarta',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12000',
            'phone' => '+62-21-123456',
            'contact_person_name' => 'Budi Santoso',
            'contact_person_phone' => '+62-812-345678',
            'contact_person_email' => 'budi@tekstil.id',
            'business_description' => 'Perusahaan tekstil yang peduli lingkungan',
            'total_waste_donated' => 5000,
            'donation_count' => 12,
            'verified' => true,
            'status' => 'verified',
        ]);

        // Create Ranger
        $ranger = User::firstOrCreate(
            ['email' => 'ranger@kalafabrics.id'],
            [
                'name'     => 'Demo Ranger',
                'password' => Hash::make('password'),
                'role'     => 'ranger',
            ]
        );
        UserPoint::firstOrCreate(['user_id' => $ranger->id], [
            'total_points' => 250,
            'redeemed_points' => 30,
            'available_points' => 220,
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Tas dan Aksesori', 'slug' => 'tas-aksesori', 'description' => 'Tas ramah lingkungan dari limbah tekstil'],
            ['name' => 'Pakaian', 'slug' => 'pakaian', 'description' => 'Pakaian upcycled berkualitas tinggi'],
            ['name' => 'Dekorasi Rumah', 'slug' => 'dekorasi-rumah', 'description' => 'Barang dekorasi dari bahan daur ulang'],
            ['name' => 'Kerajinan Tangan', 'slug' => 'kerajinan-tangan', 'description' => 'Produk kerajinan tangan edisi terbatas'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        // Create Products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Tas Belanja Ramah Lingkungan',
                'slug' => 'tas-belanja-ramah-lingkungan',
                'description' => 'Tas belanja berkualitas dari limbah tekstil pilihan',
                'environmental_impact' => 'Menyelamatkan 2 kg limbah tekstil',
                'price' => 150000,
                'stock' => 50,
                'sku' => 'BAG-001',
                'points_reward' => 15,
                'product_type' => 'both',
                'bulk_discount_percentage' => 15,
                'active' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'T-Shirt Upcycled Premium',
                'slug' => 't-shirt-upcycled-premium',
                'description' => 'Kaos berkualitas dari limbah tekstil berkualitas tinggi',
                'environmental_impact' => 'Menyelamatkan 1.5 kg limbah tekstil',
                'price' => 120000,
                'stock' => 80,
                'sku' => 'TSH-001',
                'points_reward' => 12,
                'product_type' => 'b2c',
                'active' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Taplak Meja Unik',
                'slug' => 'taplak-meja-unik',
                'description' => 'Taplak meja dengan desain unik dari patchwork tekstil',
                'environmental_impact' => 'Menyelamatkan 1 kg limbah tekstil',
                'price' => 85000,
                'stock' => 100,
                'sku' => 'DEC-001',
                'points_reward' => 8,
                'product_type' => 'both',
                'bulk_discount_percentage' => 20,
                'active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }

        // Create Impact Metrics
        ImpactMetric::firstOrCreate([], [
            'total_waste_collected_kg' => 50000,
            'total_carbon_saved_kg' => 15000,
            'water_saved_liters' => 500000,
            'total_products_sold' => 1200,
            'total_users' => 5000,
            'total_b2b_partners' => 45,
            'active_volunteers' => 120,
            'total_workshops_completed' => 35,
            'total_workshop_participants' => 850,
            'total_donation_value' => 250000000,
        ]);
    }
}
