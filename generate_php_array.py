import json
with open('cat_products_full.json') as f:
    data = json.load(f)

# generate PHP array
php = "        $categories = [\n"
for cat_slug, products in data.items():
    if cat_slug == 'cat-agatha-paint-531053':
        name = 'Agatha Paint'
        desc = 'Produk cat merk Agatha Paint berkualitas tinggi untuk industri dan komersial.'
    elif cat_slug == 'cat-hempel-paint-531054':
        name = 'Hempel Paint'
        desc = 'Produk cat merk Hempel Paint untuk perlindungan korosi industri dan maritim.'
    elif cat_slug == 'cat-international-paint-531055':
        name = 'International Paint'
        desc = 'Produk cat merk International Paint untuk perlindungan industri dan infrastruktur.'
    elif cat_slug == 'cat-jotun-paint-531056':
        name = 'Jotun Paint'
        desc = 'Produk cat merk Jotun Paint untuk perlindungan korosi dan estetika bangunan.'
    elif cat_slug == 'cat-sigma-coating-531058':
        name = 'PPG Sigma Paint'
        desc = 'Produk cat merk PPG Sigma untuk pelindung industri maritim dan infrastruktur.'
    else:
        name = 'PT Biner Own Brand'
        desc = 'Produk merk sendiri PT Biner untuk kebutuhan cat jalan, cat besi, dan pelapis khusus.'
    
    products_str = ','.join(f"'{p}'" for p in products)
    php += f"            ['name' => '{name}', 'slug' => '{cat_slug}', 'description' => '{desc}', 'products' => [{products_str}]],\n"
php += '        ];'

with open('temp_categories_array.php', 'w') as f:
    f.write(php)
print('Generated temp_categories_array.php')
