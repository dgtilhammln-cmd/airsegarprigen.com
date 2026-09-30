import json

with open('category_data.json', encoding='utf-8') as f:
    data = json.load(f)

json_str = json.dumps(data)

php_code = """<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use App\Models\Service;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = json_decode('""" + json_str + """', true);
        foreach($categories as $catData) {
            $cat = ServiceCategory::firstOrCreate(
                ['slug' => $catData['slug']],
                [
                    'name' => $catData['name'],
                    'description' => $catData['description']
                ]
            );
            
            foreach($catData['products'] as $pSlug) {
                Service::where('slug', $pSlug)->update(['service_category_id' => $cat->id]);
            }
        }
        echo "Categories seeded and products mapped.\\n";
    }
}
"""

with open('database/seeders/CategorySeeder.php', 'w', encoding='utf-8') as f:
    f.write(php_code)
