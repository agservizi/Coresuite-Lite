<?php
// app/Helpers/validation.php

use Core\Locale;

class Validation {
    private $errors = [];

    public function validate($data, $rules) {
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {
                $label = $this->fieldLabel($field);
                if ($r === 'required' && empty($value)) {
                    $this->errors[$field] = $this->message('required', ['field' => $label]);
                } elseif ($r === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = $this->message('email');
                } elseif (strpos($r, 'min:') === 0) {
                    $min = (int) substr($r, 4);
                    if (strlen($value) < $min) {
                        $this->errors[$field] = $this->message('min', ['field' => $label, 'min' => $min]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    private function fieldLabel(string $field): string {
        $labels = [
            'it' => ['name' => 'Nome', 'email' => 'Email', 'password' => 'Password', 'subject' => 'Oggetto', 'category' => 'Categoria', 'body' => 'Messaggio'],
            'en' => ['name' => 'Name', 'email' => 'Email', 'password' => 'Password', 'subject' => 'Subject', 'category' => 'Category', 'body' => 'Message'],
            'fr' => ['name' => 'Nom', 'email' => 'Email', 'password' => 'Mot de passe', 'subject' => 'Sujet', 'category' => 'Categorie', 'body' => 'Message'],
            'es' => ['name' => 'Nombre', 'email' => 'Email', 'password' => 'Contrasena', 'subject' => 'Asunto', 'category' => 'Categoria', 'body' => 'Mensaje'],
        ];
        $locale = Locale::current();
        return $labels[$locale][$field] ?? ucfirst(str_replace('_', ' ', $field));
    }

    private function message(string $key, array $replace = []): string {
        $messages = [
            'it' => [
                'required' => ':field e obbligatorio',
                'email' => 'Email non valida',
                'min' => ':field deve essere almeno :min caratteri',
            ],
            'en' => [
                'required' => ':field is required',
                'email' => 'Invalid email',
                'min' => ':field must be at least :min characters',
            ],
            'fr' => [
                'required' => ':field est obligatoire',
                'email' => 'Email invalide',
                'min' => ':field doit contenir au moins :min caracteres',
            ],
            'es' => [
                'required' => ':field es obligatorio',
                'email' => 'Email no valido',
                'min' => ':field debe tener al menos :min caracteres',
            ],
        ];
        $locale = Locale::current();
        $message = $messages[$locale][$key] ?? $messages['it'][$key] ?? $key;
        foreach ($replace as $replaceKey => $value) {
            $message = str_replace(':' . $replaceKey, (string)$value, $message);
        }
        return $message;
    }
}
