<?php
// app/Helpers/validation.php

class Validation {
    private $errors = [];

    public function validate($data, $rules) {
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {
                if ($r === 'required' && empty($value)) {
                    $this->errors[$field] = ucfirst($field) . ' è obbligatorio';
                } elseif ($r === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = 'Email non valida';
                } elseif (strpos($r, 'min:') === 0) {
                    $min = (int) substr($r, 4);
                    if (strlen($value) < $min) {
                        $this->errors[$field] = ucfirst($field) . ' deve essere almeno ' . $min . ' caratteri';
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
}