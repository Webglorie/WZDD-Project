import os
import re

def get_model_names():
    model_names = []
    files = os.listdir('app/Models')

    for file in files:
        if file.endswith('.php'):
            model_names.append(file[:-4])

    return model_names

def get_model_relations(model_name):
    relations = []
    model_path = os.path.join('app/Models', model_name + '.php')

    with open(model_path, 'r') as file:
        content = file.read()

        # Zoek naar 'hasMany' relaties
        matches = re.findall(r'public function (\w+)\(\)\s*\{.*?return \$this->hasMany\(.*?::class\);', content, re.DOTALL)
        for match in matches:
            relations.append((model_name, match, 'hasMany'))

        # Zoek naar 'belongsTo' relaties
        matches = re.findall(r'public function (\w+)\(\)\s*\{.*?return \$this->belongsTo\(.*?::class\);', content, re.DOTALL)
        for match in matches:
            relations.append((model_name, match, 'belongsTo'))

        # Voeg hier andere soorten relaties toe (bijv. hasOne, belongsToMany, enzovoort) als dat nodig is

    return relations

def get_model_controller_mapping():
    model_controller_mapping = {}
    files = os.listdir('app/Http/Controllers')

    for file in files:
        if file.endswith('.php'):
            controller_name = file[:-4]
            controller_path = os.path.join('app/Http/Controllers', file)

            with open(controller_path, 'r') as file:
                content = file.read()

                matches = re.findall(r'return view\(.*?, compact\(\'(\w+)\'\)\);', content)
                for match in matches:
                    if match in model_controller_mapping:
                        model_controller_mapping[match].append(controller_name)
                    else:
                        model_controller_mapping[match] = [controller_name]

    return model_controller_mapping

# Voorbeeldgebruik
models = get_model_names()
relations = []
model_controller_mapping = get_model_controller_mapping()

for model in models:
    model_relations = get_model_relations(model)
    relations.extend(model_relations)

# Schrijf de namen van de modellen, controllers en relaties naar een tekstbestand in de hoofdmap van Laravel
output_path = os.path.join(os.getcwd(), 'model_controller_relations.txt')

with open(output_path, 'w') as file:
    file.write("Modelklassen, Controllerklassen en Relaties:\n")
    for relation in relations:
        model_name = relation[0]
        controller_names = model_controller_mapping.get(model_name, [])

        file.write(f"Model: {model_name}\n")
        file.write("Controllers: " + ", ".join(controller_names) + "\n")
        file.write(f"Relatie ({relation[2]}): {relation[1]}\n")
        file.write("\n")

print("De namen van de modellen, controllers en relaties zijn opgeslagen in model_controller_relations.txt.")
