<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Recaptcha;

class ContactSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * NOTA: Formulario público, no requiere autenticación
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * NOTA: Solo POST (formulario de contacto público)
     */
    public function rules(): array
    {
        // Solo POST - Nunca PUT (es un formulario público)
        if ($this->isMethod('post')) {
            return [
                // ============================================
                // INFORMACIÓN DEL REMITENTE
                // ============================================
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    'regex:/^[\pL][\pL\s\-\.\']*$/u',
                ],
                
                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],
                
                'phone' => [
                    'nullable', // ✅ CAMBIADO: Ahora es opcional según la migración
                    'string',
                    'max:20',
                    'regex:/^[\d\s\+\-\(\)]+$/', // ✅ CAMBIADO: Formato internacional
                ],
                
                // ============================================
                // CONTENIDO DEL MENSAJE
                // ============================================
                'subject' => [
                    'nullable', // ✅ CAMBIADO: Ahora es opcional según la migración
                    'string',
                    'min:5',
                    'max:255',
                    // Prohibir URLs
                    'regex:/^(?!.*(https?:\/\/|www\.|ftp:\/\/)).*$/i',
                    // Validación personalizada
                    function ($attribute, $value, $fail) {
                        if (!$value) return; // Si es null, skip validación
                        
                        $forbiddenChars = ['<', '>', '{', '}', '[', ']', '\\'];
                        foreach ($forbiddenChars as $char) {
                            if (str_contains($value, $char)) {
                                $fail('El asunto contiene caracteres no permitidos (<, >, {, }, [, ], /, \\).');
                                return;
                            }
                        }
                    },
                ],

                'message' => [
                    'required',
                    'string',
                    'min:10',
                    'max:2000',
                    // Validación personalizada
                    function ($attribute, $value, $fail) {
                        $forbiddenChars = ['<', '>', '{', '}', '[', ']', '\\'];
                        foreach ($forbiddenChars as $char) {
                            if (str_contains($value, $char)) {
                                $fail('El mensaje contiene caracteres no permitidos (<, >, {, }, [, ], /, \\).');
                                return;
                            }
                        }
                    },
                    // Validación de URLs
                    function ($attribute, $value, $fail) {
                        $urlPattern = '/(https?:\/\/|www\.)[^\s]+/i';
                        preg_match_all($urlPattern, $value, $matches);

                        if (count($matches[0]) > 0) {
                            $fail('El mensaje no puede contener enlaces web. Por favor escribe tu consulta sin URLs.');
                        }

                        $suspiciousShorteners = ['bit.ly', 'tinyurl', 'goo.gl', 't.co', 'ow.ly'];
                        foreach ($suspiciousShorteners as $shortener) {
                            if (stripos($value, $shortener) !== false) {
                                $fail('No se permiten enlaces acortados por motivos de seguridad.');
                            }
                        }
                    },
                ],

                // ============================================
                // RECAPTCHA
                // ============================================
                'g-recaptcha-response' => [
                    'required',
                    new Recaptcha(),
                ],
            ];
        }

        return [];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // ============================================
            // NOMBRE COMPLETO
            // ============================================
            'name.required' => 'Por favor ingresa tu nombre completo.',
            'name.string' => 'El nombre debe contener solo texto.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios, guiones (-), puntos (.) y apóstrofes (\').',

            // ============================================
            // EMAIL
            // ============================================
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor ingresa un correo electrónico válido (ejemplo: tu@correo.com).',
            'email.max' => 'El correo electrónico no puede superar los 255 caracteres.',

            // ============================================
            // TELÉFONO
            // ============================================
            'phone.string' => 'El teléfono debe ser texto.',
            'phone.max' => 'El teléfono no puede superar los 20 caracteres.',
            'phone.regex' => 'El teléfono solo puede contener números, espacios, +, -, ( y ).',

            // ============================================
            // ASUNTO
            // ============================================
            'subject.string' => 'El asunto debe ser texto.',
            'subject.min' => 'El asunto debe tener al menos 5 caracteres.',
            'subject.max' => 'El asunto no puede superar los 255 caracteres.',
            'subject.regex' => 'El asunto contiene caracteres no permitidos. No se permiten enlaces web, ni caracteres especiales como < > { } [ ] / \\',

            // ============================================
            // MENSAJE
            // ============================================
            'message.required' => 'El mensaje es obligatorio.',
            'message.string' => 'El mensaje debe ser texto.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres para poder ayudarte mejor.',
            'message.max' => 'El mensaje no puede superar los 2000 caracteres.',
            'message.regex' => 'El mensaje contiene caracteres no permitidos. No se permiten etiquetas HTML ni caracteres especiales como < > { } [ ] / \\',

            // ============================================
            // RECAPTCHA
            // ============================================
            'g-recaptcha-response.required' => 'Por favor confirma que no eres un robot marcando la casilla de verificación.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre completo',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
            'subject' => 'asunto',
            'message' => 'mensaje',
        ];
    }

    /**
     * Prepare the data for validation.
     * 
     * IMPORTANTE: Sanitizamos datos ANTES de validar
     */
    protected function prepareForValidation(): void
    {
        $data = [];

        // Limpiar email (lowercase y trim)
        if ($this->has('email')) {
            $data['email'] = strtolower(trim($this->email ?? ''));
        }

        // Limpiar nombre
        if ($this->has('name')) {
            $name = trim(preg_replace('/\s+/', ' ', $this->name ?? ''));
            $data['name'] = $name; // ✅ CAMBIADO: Sin mb_strtoupper para mantener mayúsculas/minúsculas
        }

        // Limpiar teléfono
        if ($this->has('phone') && $this->phone) {
            $data['phone'] = trim($this->phone);
        }

        // ============================================
        // ASUNTO - SANITIZACIÓN
        // ============================================
        if ($this->has('subject') && $this->subject) {
            $subject = trim($this->subject ?? '');

            // Remover múltiples espacios
            $subject = preg_replace('/\s+/', ' ', $subject);

            // Remover caracteres invisibles y de control
            $subject = preg_replace('/[\x00-\x1F\x7F]/u', '', $subject);

            $data['subject'] = $subject;
        }

        // ============================================
        // MENSAJE - SANITIZACIÓN
        // ============================================
        if ($this->has('message')) {
            $message = trim($this->message ?? '');

            // Normalizar saltos de línea
            $message = preg_replace('/\r\n|\r|\n/', "\n", $message);

            // Limitar saltos de línea consecutivos a 2
            $message = preg_replace('/\n{3,}/', "\n\n", $message);

            // Remover caracteres de control peligrosos (excepto saltos de línea \n)
            $message = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $message);

            $data['message'] = $message;
        }

        $this->merge($data);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            
            // ============================================
            // VALIDACIÓN ADICIONAL DE SEGURIDAD PARA ASUNTO
            // ============================================
            $subject = $this->subject;
            if ($subject) {
                // Detectar palabras clave de spam
                $spamKeywords = ['viagra', 'casino', 'lottery', 'prize', 'click here', 'free money', 'sex', 'porn'];
                foreach ($spamKeywords as $keyword) {
                    if (stripos($subject, $keyword) !== false) {
                        $validator->errors()->add(
                            'subject',
                            'El asunto contiene palabras no permitidas. Por favor reformula tu mensaje.'
                        );
                        break;
                    }
                }

                // Detectar caracteres repetidos sospechosos (ej: $$$$, !!!!)
                if (preg_match('/(.)\1{4,}/', $subject)) {
                    $validator->errors()->add(
                        'subject',
                        'El asunto contiene caracteres repetidos de forma sospechosa.'
                    );
                }
            }

            // ============================================
            // VALIDACIÓN ADICIONAL DE SEGURIDAD PARA MENSAJE
            // ============================================
            $message = $this->message;
            if ($message) {
                // Detectar palabras clave de spam en mensaje
                $spamKeywords = ['viagra', 'casino', 'lottery', 'prize', 'click here', 'free money', 'sex', 'porn'];
                $spamCount = 0;
                foreach ($spamKeywords as $keyword) {
                    if (stripos($message, $keyword) !== false) {
                        $spamCount++;
                    }
                }

                if ($spamCount >= 2) {
                    $validator->errors()->add(
                        'message',
                        'El mensaje contiene contenido que parece spam. Por favor reformula tu consulta.'
                    );
                }
            }

            // ============================================
            // DETECCIÓN DE ENTIDADES HTML
            // ============================================
            $subject = $this->subject;
            if ($subject && preg_match('/&#[0-9]+;|&[a-z]+;/i', $subject)) {
                $validator->errors()->add(
                    'subject',
                    'El asunto contiene código HTML ofuscado no permitido.'
                );
            }

            $message = $this->message;
            if ($message && preg_match('/&#[0-9]+;|&[a-z]+;/i', $message)) {
                $validator->errors()->add(
                    'message',
                    'El mensaje contiene código HTML ofuscado no permitido.'
                );
            }
        });
    }
}