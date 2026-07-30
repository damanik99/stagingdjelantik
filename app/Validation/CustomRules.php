<?php 

namespace App\Validation;

class CustomRules
{
    public function exclusiveRequired(
    string $value,
    string $fields,
    array $data,
    ?string &$error = null
    ): bool {

        $fields = array_map('trim', explode(',', $fields));

        $filled = [];

        foreach ($fields as $field) {
            if (!empty($data[$field])) {
                $filled[] = $field;
            }
        }

        if (count($filled) === 0) {
            $error = 'Salah satu field harus diisi.';
            return false;
        }

        if (count($filled) > 1) {
            $error = 'Hanya satu field yang boleh diisi.';
            return false;
        }

        return true;
    }
}

