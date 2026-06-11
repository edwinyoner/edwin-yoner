<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TechnologieCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return auth()->check() && (
        //     auth()->user()->hasPermissionTo('crear categorias tecnologias') ||
        //     auth()->user()->hasPermissionTo('actualizar categorias tecnologias')
        // );

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // ============================================
        // POST: Crear nueva categoría
        // ============================================
        if ($this->isMethod('post')) {
            return [
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    'unique:technologie_categories,name',
                ],
                
                'name_en' => [
                    'nullable',
                    'string',
                    'min:3',
                    'max:255',
                ],
                
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', // Solo minúsculas, números y guiones
                    'unique:technologie_categories,slug',
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
                
                'description' => [
                    'nullable',
                    'string',
                    'max:500',
                ],
                
                'is_active' => 'nullable|boolean',
            ];
        }

        // ============================================
        // PUT: Actualizar categoría existente
        // ============================================
        if ($this->isMethod('put')) {
            $categoryId = $this->route('technology_category') ? $this->route('technology_category')->id : null;
            
            return [
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    Rule::unique('technologie_categories', 'name')->ignore($categoryId),
                ],
                
                'name_en' => [
                    'nullable',
                    'string',
                    'min:3',
                    'max:255',
                ],
                
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    Rule::unique('technologie_categories', 'slug')->ignore($categoryId),
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
                
                'description' => [
                    'nullable',
                    'string',
                    'max:500',
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
            // Name
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'name.unique' => 'Ya existe una categoría con este nombre.',
            
            // Name EN
            'name_en.min' => 'El nombre en inglés debe tener al menos 3 caracteres.',
            'name_en.max' => 'El nombre en inglés no puede exceder los 255 caracteres.',
            
            // Slug
            'slug.required' => 'El slug es obligatorio.',
            'slug.max' => 'El slug no puede exceder los 255 caracteres.',
            'slug.regex' => 'El slug solo puede contener letras minúsculas, números y guiones (Ej: frontend-development).',
            'slug.unique' => 'Ya existe una categoría con este slug.',
            
            // Icon Class
            'icon_class.max' => 'La clase de icono no puede exceder los 100 caracteres.',
            
            // Color
            'color.regex' => 'El color debe tener formato hexadecimal válido (Ej: #3b82f6).',
            
            // Description
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',
            
            // Is Active
            'is_active.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'name_en' => 'nombre en inglés',
            'slug' => 'slug',
            'icon_class' => 'clase de icono',
            'color' => 'color',
            'description' => 'descripción',
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
            
            // Auto-generar slug si no viene (solo en POST)
            if ($this->isMethod('post') && !$this->filled('slug')) {
                $data['slug'] = Str::slug($data['name']);
            }
        }

        // Normalizar nombre en inglés
        if ($this->filled('name_en')) {
            $data['name_en'] = trim($this->name_en);
        }

        // Normalizar slug
        if ($this->filled('slug')) {
            $data['slug'] = Str::slug($this->slug);
        }

        // Normalizar color (asegurar # y mayúsculas)
        if ($this->filled('color')) {
            $color = trim($this->color);
            if (!str_starts_with($color, '#')) {
                $color = '#' . $color;
            }
            $data['color'] = strtoupper($color);
        }

        // Normalizar descripción
        if ($this->filled('description')) {
            $data['description'] = trim($this->description);
        }

        // Manejar checkbox is_active
        if ($this->has('is_active')) {
            $data['is_active'] = $this->boolean('is_active');
        } else {
            $data['is_active'] = false;
        }

        $this->merge($data);
    }
}