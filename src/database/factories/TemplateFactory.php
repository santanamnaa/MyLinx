<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    protected $model = Template::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $templates = [
            ['nama' => 'Minimalist E-Commerce', 'kategori' => 'e-commerce'],
            ['nama' => 'Bold Portfolio', 'kategori' => 'portfolio'],
            ['nama' => 'Classic Company Profile', 'kategori' => 'company-profile'],
            ['nama' => 'Modern Catalog', 'kategori' => 'catalog'],
        ];

        $template = fake()->randomElement($templates);

        return [
            'nama_template' => $template['nama'],
            'kategori'      => $template['kategori'],
            'preview_url'   => '/images/templates/' . \Illuminate\Support\Str::slug($template['nama']) . '.png',
            'is_active'     => true,
        ];
    }
}
