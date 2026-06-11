<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;//auth()->check() && auth()->user()->hasPermissionTo('editar configuracion perfil');
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
                // Foto de perfil
                'profile_image' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:2048', // 2MB
                ],
                
                // Información personal
                'full_name' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255',
                    'regex:/^[\pL\s\-]+$/u', // Solo letras, espacios y guiones
                ],
                
                'professional_title' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255',
                ],
                
                // Biografías
                'bio_short' => [
                    'nullable',
                    'string',
                    'max:500', // 2-3 líneas
                ],
                
                'bio_long' => [
                    'nullable',
                    'string',
                    'max:2000', // Biografía extendida
                ],
                
                // Ubicación
                'city' => [
                    'required',
                    'string',
                    'max:100',
                ],
                
                'country' => [
                    'required',
                    'string',
                    'max:100',
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
            // Profile Image
            'profile_image.image' => 'El archivo debe ser una imagen.',
            'profile_image.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o webp.',
            'profile_image.max' => 'La imagen no puede superar los 2MB.',
            
            // Full Name
            'full_name.required' => 'El nombre completo es obligatorio.',
            'full_name.min' => 'El nombre debe tener al menos 5 caracteres.',
            'full_name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'full_name.regex' => 'El nombre solo puede contener letras, espacios y guiones.',
            
            // Professional Title
            'professional_title.required' => 'El título profesional es obligatorio.',
            'professional_title.min' => 'El título profesional debe tener al menos 5 caracteres.',
            'professional_title.max' => 'El título profesional no puede exceder los 255 caracteres.',
            
            // Bio Short
            'bio_short.max' => 'La descripción corta no puede exceder los 500 caracteres.',
            
            // Bio Long
            'bio_long.max' => 'La biografía extendida no puede exceder los 2000 caracteres.',
            
            // City
            'city.required' => 'La ciudad es obligatoria.',
            'city.max' => 'La ciudad no puede exceder los 100 caracteres.',
            
            // Country
            'country.required' => 'El país es obligatorio.',
            'country.max' => 'El país no puede exceder los 100 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'profile_image' => 'foto de perfil',
            'full_name' => 'nombre completo',
            'professional_title' => 'título profesional',
            'bio_short' => 'descripción corta',
            'bio_long' => 'biografía extendida',
            'city' => 'ciudad',
            'country' => 'país',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = [];

        // Normalizar textos
        if ($this->filled('full_name')) {
            $data['full_name'] = trim($this->full_name);
        }

        if ($this->filled('professional_title')) {
            $data['professional_title'] = trim($this->professional_title);
        }

        if ($this->filled('bio_short')) {
            $data['bio_short'] = trim($this->bio_short);
        }

        if ($this->filled('bio_long')) {
            $data['bio_long'] = trim($this->bio_long);
        }

        if ($this->filled('city')) {
            $data['city'] = trim($this->city);
        }

        if ($this->filled('country')) {
            $data['country'] = trim($this->country);
        }

        $this->merge($data);
    }
}