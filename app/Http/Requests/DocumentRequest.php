<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // ============================================
        // POST: Crear nuevo documento
        // ============================================
        if ($this->isMethod('post')) {
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'file_path' => [
                    'nullable',
                    'file',
                    'mimes:pdf',
                    'max:20480',   // era 5120 (5MB) → ahora 20480 (20MB)
                ],

                'icon_class' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'color' => [
                    'nullable',
                    'string',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],

                'is_active' => 'nullable|boolean',
            ];
        }

        // ============================================
        // PUT: Actualizar documento existente
        // ============================================
        if ($this->isMethod('put')) {
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'file_path' => [
                    'nullable',
                    'file',
                    'mimes:pdf',
                    'max:20480',   // era 5120 (5MB) → ahora 20480 (20MB)
                ],

                'icon_class' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'color' => [
                    'nullable',
                    'string',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],

                'is_active' => 'nullable|boolean',
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
            'title.required' => 'El título del documento es obligatorio.',
            'title.min' => 'El título debe tener al menos 3 caracteres.',
            'title.max' => 'El título no puede exceder los 255 caracteres.',

            'description.max' => 'La descripción no puede exceder los 1000 caracteres.',

            'file_path.file' => 'El archivo debe ser un documento válido.',
            'file_path.mimes' => 'El documento debe ser un archivo PDF.',
            'file_path.max' => 'El documento no puede superar los 20MB.',

            'icon_class.max' => 'La clase de icono no puede exceder los 100 caracteres.',

            'color.regex' => 'El color debe tener formato hexadecimal válido (Ej: #ef4444).',

            'is_active.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'título',
            'description' => 'descripción',
            'file_path' => 'archivo PDF',
            'icon_class' => 'clase de icono',
            'color' => 'color',
            'is_active' => 'estado',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = [];

        // Normalizar título
        if ($this->filled('title')) {
            $data['title'] = trim($this->title);
        }

        // Normalizar descripción
        if ($this->filled('description')) {
            $data['description'] = trim($this->description);
        }

        // Normalizar icon_class
        if ($this->filled('icon_class')) {
            $data['icon_class'] = trim($this->icon_class);
        }

        // Normalizar color (asegurar # y mayúsculas)
        if ($this->filled('color')) {
            $color = trim($this->color);
            if (!str_starts_with($color, '#')) {
                $color = '#' . $color;
            }
            $data['color'] = strtoupper($color);
        }

        // Manejar checkbox is_active
        $data['is_active'] = $this->boolean('is_active');

        $this->merge($data);
    }
}
