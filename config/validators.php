<?php

function validations(array $datas, array $rules): array {
    $errors = [];

    foreach ($rules as $field => $fieldRules) {
        $value = isset($datas[$field]) ? $datas[$field] : '';
        $rulesArray = explode('|', $fieldRules);

        foreach ($rulesArray as $rule) {
            
            if ($rule === 'required') {
                if (!isset($datas[$field]) || trim((string)$value) === '') {
                    $errors[$field] = "Ce champ est obligatoire.";
                    break; 
                }
            }

            if (trim((string)$value) === '') {
                continue;
            }

            if ($rule === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "L'adresse email n'est pas valide.";
                }
            }

            if ($rule === 'numeric') {
                if (!is_numeric($value)) {
                    $errors[$field] = "Ce champ doit être un nombre.";
                }
            }
        }
    }

    return $errors;
}

function validate(array $errors): bool {
    return count($errors) === 0;
}