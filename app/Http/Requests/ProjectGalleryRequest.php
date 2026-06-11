<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return auth()->check() && (
        //     auth()->user()->hasPermissionTo('crear galeria proyectos') ||
        //     auth()->user()->hasPermissionTo('actualizar galeria proyectos')
        // );

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * NOTA: La validación de 3-5 imágenes por proyecto se hace en el controlador,
     * no aquí (este Request valida UNA imagen a la vez)
     */
    public function rules(): array
    {
        // ============================================
        // POST: Agregar nueva imagen a la galería
        // ============================================
        if ($this->isMethod('post')) {
            return [
                // Relación (viene de la URL, no del formulario)
                // project_id se obtiene de la ruta: /projects/{project}/gallery
                
                // Imagen (OBLIGATORIA en POST)
                'image_path' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:3072', // 3MB (imágenes de galería pueden ser más grandes)
                ],
                
                // Caption
                'caption' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
            ];
        }

        // ============================================
        // PUT: Actualizar imagen existente
        // ============================================
        if ($this->isMethod('put')) {
            return [
                // Imagen (OPCIONAL en PUT - solo si se quiere cambiar)
                'image_path' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:3072', // 3MB
                ],
                
                // Caption
                'caption' => [
                    'nullable',
                    'string',
                    'max:255',
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
            // Image Path
            'image_path.required' => 'La imagen es obligatoria.',
            'image_path.image' => 'El archivo debe ser una imagen.',
            'image_path.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o webp.',
            'image_path.max' => 'La imagen no puede superar los 3MB.',
            
            // Caption
            'caption.max' => 'La descripción no puede exceder los 255 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'image_path' => 'imagen',
            'caption' => 'descripción',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = [];

        // Normalizar caption
        if ($this->filled('caption')) {
            $data['caption'] = trim($this->caption);
        }

        $this->merge($data);
    }
}