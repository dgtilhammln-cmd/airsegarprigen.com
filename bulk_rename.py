import os
import re

directories_to_scan = [
    'resources/views',
    'app',
    'database/seeders'
]

file_extensions = ['.php', '.blade.php', '.md']

replacements = [
    (r'cyclevent\.ventilator58@gmail\.com', 'info@ptbiner.co.id'),
    (r'www\.cyclevent\.com', 'www.ptbiner.co.id'),
    (r'cyclevent\.com', 'ptbiner.co.id'),
    (r'Cyclevent', 'PT Biner'),
    (r'CYCLEVENT', 'PT BINER'),
    (r'cyclevent', 'ptbiner'),
    (r'Turbine Ventilator', 'Cat Industri'),
    (r'turbine ventilator', 'cat industri'),
    (r'Turbine ventilator', 'Cat industri'),
]

def process_file(filepath):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
    except Exception as e:
        return

    original_content = content
    for pattern, repl in replacements:
        content = re.sub(pattern, repl, content)

    if content != original_content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {filepath}")

for d in directories_to_scan:
    for root, dirs, files in os.walk(d):
        for file in files:
            if any(file.endswith(ext) for ext in file_extensions):
                process_file(os.path.join(root, file))

print("Replacement complete.")
