<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //auth()->check() && auth()->user()->hasPermissionTo('editar configuracion portafolio');
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * NOTA: Solo PUT porque es un singleton (1 registro en la tabla)
     */
    public function rules(): array
    {
        // SINGLETON: Solo PUT (editar), nunca POST (crear)
        if ($this->isMethod('put')) {
            return [
                // ============================================
                // IDENTIDAD VISUAL
                // ============================================
                'logo_path' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:5120|dimensions:min_width=200,min_height=80',

                // FAVICON CORREGIDO - Validación por extensión, no por MIME
                'favicon_path' => [
                    'nullable',
                    'file',
                    'max:512', // 512KB máximo
                    function ($attribute, $value, $fail) {
                        if (!$value || !$value->isValid()) {
                            return;
                        }

                        // Obtener extensión real del archivo
                        $extension = strtolower($value->getClientOriginalExtension());

                        // VALIDAR SOLO POR EXTENSIÓN (no por MIME type)
                        if (!in_array($extension, ['ico', 'png'])) {
                            $fail('El favicon debe ser un archivo ICO o PNG.');
                            return;
                        }

                        // VALIDAR DIMENSIONES SOLO PARA PNG
                        if ($extension === 'png') {
                            try {
                                $imageInfo = @getimagesize($value->getRealPath());

                                if ($imageInfo === false) {
                                    $fail('El archivo PNG no es válido.');
                                    return;
                                }

                                [$width, $height] = $imageInfo;

                                // Dimensiones mínimas
                                if ($width < 16 || $height < 16) {
                                    $fail('El favicon PNG debe tener al menos 16x16 píxeles.');
                                    return;
                                }

                                // Dimensiones máximas
                                if ($width > 512 || $height > 512) {
                                    $fail('El favicon PNG no debe exceder 512x512 píxeles.');
                                    return;
                                }
                            } catch (\Exception $e) {
                                // Si falla getimagesize, permitir el archivo
                            }
                        }

                        // VALIDAR TAMAÑO PARA ICO (no podemos validar dimensiones)
                        if ($extension === 'ico') {
                            $sizeInKB = $value->getSize() / 1024;

                            if ($sizeInKB > 512) {
                                $fail('El favicon ICO no puede exceder 512KB.');
                            }
                        }
                    },
                ],

                // ============================================
                // PALETA DE COLORES
                // ============================================
                'primary_color' => [
                    'required',
                    'string',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],

                'secondary_color' => [
                    'required',
                    'string',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],

                'tertiary_color' => [
                    'required',
                    'string',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],

                'text_dark_color' => [
                    'required',
                    'string',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],

                'text_light_color' => [
                    'required',
                    'string',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],

                // ============================================
                // CONTACTO
                // ============================================
                'email_contact' => [
                    'nullable',
                    'email',
                    'max:255',
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                    'regex:/^[\d\s\+\-\(\)]+$/',
                ],

                'whatsapp_number' => [
                    'nullable',
                    'string',
                    'max:20',
                    'regex:/^\d{11,15}$/', // Ej: 51912345678 (código país + número)
                ],

                // ============================================
                // CONFIGURACIÓN SITIO
                // ============================================
                'enable_dark_mode' => [
                    'required',
                    'boolean',
                ],

                'enable_multilang' => [
                    'required',
                    'boolean',
                ],

                'default_language' => [
                    'required',
                    'string',
                    'in:es,en',
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
            // Identidad Visual
            'logo_path.image' => 'El logo debe ser una imagen.',
            'logo_path.mimes' => 'El logo debe ser de tipo: png, svg, webp, jpg o jpeg.',
            'logo_path.max' => 'El logo no puede superar 1MB.',

            // FAVICON CORREGIDO
            'favicon_path.file' => 'El favicon debe ser un archivo válido.',
            'favicon_path.mimes' => 'El favicon debe ser ICO o PNG.',
            'favicon_path.max' => 'El favicon no puede exceder los 512KB.',

            // Paleta de Colores
            'primary_color.required' => 'El color primario es obligatorio.',
            'primary_color.regex' => 'El color primario debe tener formato hexadecimal válido (Ej: #d4af37).',

            'secondary_color.required' => 'El color secundario es obligatorio.',
            'secondary_color.regex' => 'El color secundario debe tener formato hexadecimal válido (Ej: #1f2937).',

            'tertiary_color.required' => 'El color terciario es obligatorio.',
            'tertiary_color.regex' => 'El color terciario debe tener formato hexadecimal válido (Ej: #f9fafb).',

            'text_dark_color.required' => 'El color de texto oscuro es obligatorio.',
            'text_dark_color.regex' => 'El color de texto oscuro debe tener formato hexadecimal válido.',

            'text_light_color.required' => 'El color de texto claro es obligatorio.',
            'text_light_color.regex' => 'El color de texto claro debe tener formato hexadecimal válido.',

            // Contacto
            'email_contact.email' => 'El email debe ser una dirección válida.',
            'email_contact.max' => 'El email no puede exceder los 255 caracteres.',

            'phone.max' => 'El teléfono no puede exceder los 20 caracteres.',
            'phone.regex' => 'El teléfono solo puede contener números, espacios, +, -, ( y ).',

            'whatsapp_number.max' => 'El WhatsApp no puede exceder los 20 caracteres.',
            'whatsapp_number.regex' => 'El WhatsApp debe tener formato válido (Ej: 51912345678).',

            // Configuración Sitio
            'enable_dark_mode.required' => 'Debe especificar si habilita el modo oscuro.',
            'enable_dark_mode.boolean' => 'El modo oscuro debe ser verdadero o falso.',

            'enable_multilang.required' => 'Debe especificar si habilita multiidioma.',
            'enable_multilang.boolean' => 'El multiidioma debe ser verdadero o falso.',

            'default_language.required' => 'El idioma por defecto es obligatorio.',
            'default_language.in' => 'El idioma debe ser español (es) o inglés (en).',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'logo_path' => 'logo',
            'favicon_path' => 'favicon',
            'primary_color' => 'color primario',
            'secondary_color' => 'color secundario',
            'tertiary_color' => 'color terciario',
            'text_dark_color' => 'color de texto oscuro',
            'text_light_color' => 'color de texto claro',
            'email_contact' => 'email de contacto',
            'phone' => 'teléfono',
            'whatsapp_number' => 'WhatsApp',
            'enable_dark_mode' => 'modo oscuro',
            'enable_multilang' => 'multiidioma',
            'default_language' => 'idioma por defecto',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = [];

        // Normalizar colores (asegurar # y mayúsculas)
        $colorFields = [
            'primary_color',
            'secondary_color',
            'tertiary_color',
            'text_dark_color',
            'text_light_color'
        ];

        foreach ($colorFields as $colorField) {
            if ($this->filled($colorField)) {
                $color = trim($this->$colorField);
                // Agregar # si no lo tiene
                if (!str_starts_with($color, '#')) {
                    $color = '#' . $color;
                }
                $data[$colorField] = strtoupper($color);
            }
        }

        // Normalizar email
        if ($this->filled('email_contact')) {
            $data['email_contact'] = strtolower(trim($this->email_contact));
        }

        // Normalizar teléfonos (quitar espacios extras)
        if ($this->filled('phone')) {
            $data['phone'] = trim($this->phone);
        }

        if ($this->filled('whatsapp_number')) {
            // Remover +, espacios, guiones y paréntesis → solo dígitos
            $data['whatsapp_number'] = preg_replace('/[^\d]/', '', $this->whatsapp_number);
        }

        // Convertir checkboxes a boolean
        if ($this->has('enable_dark_mode')) {
            $data['enable_dark_mode'] = $this->boolean('enable_dark_mode');
        }

        if ($this->has('enable_multilang')) {
            $data['enable_multilang'] = $this->boolean('enable_multilang');
        }

        $this->merge($data);
    }
}
