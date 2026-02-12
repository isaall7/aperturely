<?php
namespace Database\Seeders;

use App\Models\Categories;
use App\Models\TypeCategories;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'     => 'admin',
            'email'    => 'admin@aperturely.com',
            'role'     => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        Categories::create([
            'name' => 'Photography',
            'slug' => 'photography',
        ]);

        Categories::create([
            'name' => 'Design Grafis',
            'slug' => 'design-grafis',
        ]);

        Categories::create([
            'name' => 'Art',
            'slug' => 'art',
        ]);

        // TypeCategories for Photography
        TypeCategories::create([
            'category_id' => 1,
            'name'        => 'Phone',
            'slug'        => 'phone',
        ]);

        TypeCategories::create([
            'category_id' => 1,
            'name'        => 'Mirrorless',
            'slug'        => 'mirrorless',
        ]);

        TypeCategories::create([
            'category_id' => 1,
            'name'        => 'DSLR',
            'slug'        => 'dslr',
        ]);

        // TypeCategories for Design Grafis
        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'UI/UX Design',
            'slug'        => 'ui-ux-design',
        ]);

        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'Graphic Design',
            'slug'        => 'graphic-design',
        ]);

        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'Web Design',
            'slug'        => 'web-design',
        ]);

        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'Flyer',
            'slug'        => 'flyer',
        ]);

        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'Product Design',
            'slug'        => 'product-design',
        ]);

        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'Film',
            'slug'        => 'film',
        ]);

        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'Logo Design',
            'slug'        => 'logo-design',
        ]);

        TypeCategories::create([
            'category_id' => 2,
            'name'        => 'Poster',
            'slug'        => 'poster',
        ]);

        // TypeCategories for Art
        TypeCategories::create([
            'category_id' => 3,
            'name'        => 'Painting',
            'slug'        => 'painting',
        ]);

        TypeCategories::create([
            'category_id' => 3,
            'name'        => 'Sculpture',
            'slug'        => 'sculpture',
        ]);

        TypeCategories::create([
            'category_id' => 3,
            'name'        => 'Digital Art',
            'slug'        => 'digital-art',
        ]);
    }
}
