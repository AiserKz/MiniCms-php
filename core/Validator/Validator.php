<?php

namespace Core\Validator;

class Validator {
    protected $data;
    protected $rules;
    protected $errors = [];

    public static function make(array $data, array $rules) {
        $v = new static();
        $v->data = $data;
        $v->rules = $rules;
        $v->validate();
        return $v;
    }

    protected function validate() {
        foreach ($this->rules as $field => $rules) {
            $rulesArray = explode('|', $rules);
            foreach ($rulesArray as $rule) {
                $value = trim($this->data[$field] ?? '');
                if ($rule === 'required' && $value === '') {
                    $this->errors[$field][] = "Поле $field обязательно для заполнения";
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int)explode(':', $rule)[1];
                    if (mb_strlen($value) < $min) {
                        $this->errors[$field][] = "Минимальная длина $field — $min символов.";
                    }
                }

                if (str_starts_with($rule, 'max:')) {
                    $max = (int)explode(':', $rule)[1];
                    if (mb_strlen($value) > $max) {
                        $this->errors[$field][] = "Максимальная длина $field — $max символов.";
                    }
                }
            }
        }
    }

    public function fails() {
        return !empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }
}