<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar els productes del JSON a la BBDD';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonFilePath = public_path('data.json');
        if (!file_exists($jsonFilePath)) {
            $this->error('No s\'ha trobat el fitxer JSON');
            return; 
        }

        $json = file_get_contents($jsonFilePath);
        $data = json_decode($json, true);

        // Verificació d'error
        if (!isset($data['products']) || empty($data['products'])) {
            $this->error('No s\'han trobat productes en el JSON.');
            return;
        }

        // Inserta categorías solo si no existen
        $categories = [
            ['category_id' => 'samarretes'],
            ['category_id' => 'dessuadores'],
            ['category_id' => 'pantalons'],
            ['category_id' => 'vestits'],
            ['category_id' => 'jaquetes'],
            ['category_id' => 'faldilles'],
            ['category_id' => 'polos'],
            ['category_id' => 'camises'],
            ['category_id' => 'bruses'],
            ['category_id' => 'jerseis'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(['category_id' => $category['category_id']], ['category_id' => $category['category_id']]);
        }

        // Inserta tamaños solo si no existen
        $sizes = [
            ['size_id' => 'S'],
            ['size_id' => 'M'],
            ['size_id' => 'L'],
            ['size_id' => 'XL'],
        ];

        foreach ($sizes as $size) {
            DB::table('sizes')->updateOrInsert(['size_id' => $size['size_id']], ['size_id' => $size['size_id']]);
        }

        // Inserta productos
        foreach ($data['products'] as $product) {
            $categoryId = DB::table('categories')->where('category_id', $product['category_id'])->value('id');
            $sizeId = DB::table('sizes')->where('size_id', $product['size_id'])->value('id');


            // Verifica que categoryId y sizeId existan
            if (is_null($categoryId)) {
                $this->error("La categoria '{$product['category_id']}' no existe.");
                continue;
            }

            if (is_null($sizeId)) {
                $this->error("El tamaño '{$product['size_id']}' no existe.");
                continue;
            }

            DB::table('products')->insert([
                'id' => $product['id'],
                'title' => $product['title'],
                'description' => $product['description'],
                'image' => $product['image'],
                'price' => $product['price'],
                'category_id' => $categoryId,
                'size_id' => $sizeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Productes importats correctament');
    }

    private function getCategoryId($category)
    {
        return DB::table('categories')->where('category_id', $category)->value('id');
    }

    private function getSizeId($size)
    {
        return DB::table('sizes')->where('size_id', $size)->value('id');
    }
}