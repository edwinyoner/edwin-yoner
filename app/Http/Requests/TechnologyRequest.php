<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TechnologyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return auth()->check() && (
        //     auth()->user()->hasPermissionTo('crear tecnologias') ||
        //     auth()->user()->hasPermissionTo('actualizar tecnologias')
        // );
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // ============================================
        // POST: Crear nueva tecnología
        // ============================================
        if ($this->isMethod('post')) {
            return [
                'technologie_category_id' => [
                    'required',
                    'integer',
                    'exists:technologie_categories,id',
                ],
                
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255',
                ],
                
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    'unique:technologies,slug',
                ],
                
                'icon_path' => [
                    'nullable',
                    'image',
                    'mimes:svg,png,jpg,jpeg,webp',
                    'max:512', // 512KB
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
                
                'proficiency_level' => [
                    'required',
                    'string',
                    'in:basico,intermedio,avanzado,experto',
                ],
                
                'proficiency_percentage' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:100',
                ],
                
                'is_active' => 'nullable|boolean',
            ];
        }

        // ============================================
        // PUT: Actualizar tecnología existente
        // ============================================
        if ($this->isMethod('put')) {
            $technologyId = $this->route('technology') ? $this->route('technology')->id : null;
            
            return [
                'technologie_category_id' => [
                    'required',
                    'integer',
                    'exists:technologie_categories,id',
                ],
                
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255',
                ],
                
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    Rule::unique('technologies', 'slug')->ignore($technologyId),
                ],
                
                'icon_path' => [
                    'nullable',
                    'image',
                    'mimes:svg,png,jpg,jpeg,webp',
                    'max:512', // 512KB
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
                
                'proficiency_level' => [
                    'required',
                    'string',
                    'in:basico,intermedio,avanzado,experto',
                ],
                
                'proficiency_percentage' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:100',
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
            // Category
            'technologie_category_id.required' => 'La categoría es obligatoria.',
            'technologie_category_id.exists' => 'La categoría seleccionada no existe.',
            
            // Name
            'name.required' => 'El nombre de la tecnología es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 2 caracteres.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            
            // Slug
            'slug.required' => 'El slug es obligatorio.',
            'slug.max' => 'El slug no puede exceder los 255 caracteres.',
            'slug.regex' => 'El slug solo puede contener letras minúsculas, números y guiones (Ej: laravel-10).',
            'slug.unique' => 'Ya existe una tecnología con este slug.',
            
            // Icon Path
            'icon_path.image' => 'El archivo debe ser una imagen.',
            'icon_path.mimes' => 'El icono debe ser de tipo: svg, png, jpg, jpeg o webp.',
            'icon_path.max' => 'El icono no puede superar los 512KB.',
            
            // Icon Class
            'icon_class.max' => 'La clase de icono no puede exceder los 100 caracteres.',
            
            // Color
            'color.regex' => 'El color debe tener formato hexadecimal válido (Ej: #FF2D20).',
            
            // Proficiency Level
            'proficiency_level.required' => 'El nivel de dominio es obligatorio.',
            'proficiency_level.in' => 'El nivel de dominio debe ser: básico, intermedio, avanzado o experto.',
            
            // Proficiency Percentage
            'proficiency_percentage.required' => 'El porcentaje de dominio es obligatorio.',
            'proficiency_percentage.integer' => 'El porcentaje debe ser un número entero.',
            'proficiency_percentage.min' => 'El porcentaje mínimo es 0.',
            'proficiency_percentage.max' => 'El porcentaje máximo es 100.',
            
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
            'technologie_category_id' => 'categoría',
            'name' => 'nombre',
            'slug' => 'slug',
            'icon_path' => 'icono',
            'icon_class' => 'clase de icono',
            'color' => 'color',
            'proficiency_level' => 'nivel de dominio',
            'proficiency_percentage' => 'porcentaje de dominio',
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

        // Normalizar icon_class
        if ($this->filled('icon_class')) {
            $data['icon_class'] = trim($this->icon_class);
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