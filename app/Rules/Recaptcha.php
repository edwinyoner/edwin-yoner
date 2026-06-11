<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('No se pudo validar reCAPTCHA.');
            return;
        }

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret'   => config('services.recaptcha.secret'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]
        );

        if (!$response->successful()) {
            $fail('Error al verificar reCAPTCHA.');
            return;
        }

        $data = $response->json();

        if (
            empty($data['success']) ||
            ($data['score'] ?? 0) < 0.5 ||
            ($data['action'] ?? '') !== 'submit'
        ) {
            $fail('reCAPTCHA detectó actividad sospechosa.');
        }
    }
}