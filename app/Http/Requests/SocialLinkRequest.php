<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SocialLinkRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $socialLinkId = $this->route('social_link')?->id;

        return [
            'name' => [
                'required',
                'string',
                'min:1',
                'max:100',
                Rule::unique('social_links', 'name')->ignore($socialLinkId),
            ],
            'icon' => [
                'required',
                'string',
                'max:100',
                'regex:/^fa[bsr]?\s+fa-[\w-]+$/',
            ],
            'url' => [
                'required',
                'url',
                'max:500',
                Rule::unique('social_links', 'url')->ignore($socialLinkId),
            ],
            'color' => [
                'nullable',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la red social es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.min' => 'El nombre debe tener al menos 1 caracter.',
            'name.max' => 'El nombre no puede exceder los 100 caracteres.',
            'name.unique' => 'Ya existe una red social con este nombre.',
            
            'icon.required' => 'El icono es obligatorio.',
            'icon.string' => 'El icono debe ser texto.',
            'icon.max' => 'El icono no puede exceder los 100 caracteres.',
            'icon.regex' => 'El icono debe ser un icono válido de FontAwesome (Ej: fab fa-facebook).',
            
            'url.required' => 'La URL es obligatoria.',
            'url.url' => 'La URL debe ser válida (Ej: https://facebook.com/empresa).',
            'url.max' => 'La URL no puede exceder los 500 caracteres.',
            'url.unique' => 'Ya existe una red social con esta URL.',
            
            'color.regex' => 'El color debe tener formato hexadecimal válido (Ej: #1877F2).',
            
            'is_active.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'icon' => 'icono',
            'url' => 'URL',
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

        // Normalizar nombre
        if ($this->filled('name')) {
            $data['name'] = trim($this->name);
        }

        // Normalizar icono
        if ($this->filled('icon')) {
            $data['icon'] = trim($this->icon);
        }

        // Normalizar URL
        if ($this->filled('url')) {
            $data['url'] = strtolower(trim($this->url));
        }

        // Normalizar color
        if ($this->filled('color')) {
            $color = trim($this->color);
            if (!str_starts_with($color, '#')) {
                $color = '#' . $color;
            }
            $data['color'] = strtoupper($color);
        }

        // CRÍTICO: Convertir checkbox a boolean
        // Si el checkbox está marcado, viene como "1" o "on"
        // Si NO está marcado, no viene en el request (null)
        if ($this->has('is_active')) {
            $data['is_active'] = $this->boolean('is_active');
        } else {
            $data['is_active'] = false; // Checkbox desmarcado = false
        }

        $this->merge($data);
    }
}