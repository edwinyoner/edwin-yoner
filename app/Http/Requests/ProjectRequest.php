<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return auth()->check() && (
        //     auth()->user()->hasPermissionTo('crear proyectos') ||
        //     auth()->user()->hasPermissionTo('actualizar proyectos')
        // );
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // ============================================
        // POST: Crear nuevo proyecto
        // ============================================
        if ($this->isMethod('post')) {
            return [
                // Relación
                'technologies' => [
                    'nullable',
                    'array',
                ],
                'technologies.*' => [
                    'integer',
                    'exists:technologies,id',
                ],

                // Información principal
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    'unique:projects,slug',
                ],

                'short_description' => [
                    'nullable',
                    'string',
                    'max:500',
                ],

                'long_description' => [
                    'nullable',
                    'string',
                    'max:10000', // 10,000 caracteres para descripción completa
                ],

                // Imágenes y multimedia
                'thumbnail_image' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:2048', // 2MB
                ],

                'video_url' => [
                    'nullable',
                    'url',
                    'max:500',
                    'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/', // Validar YouTube
                ],

                // Enlaces
                'project_url' => [
                    'nullable',
                    'url',
                    'max:500',
                ],

                'repository_url' => [
                    'nullable',
                    'url',
                    'max:500',
                    'regex:/^(https?:\/\/)?(www\.)?(github\.com|gitlab\.com)\/.+$/', // Validar repositorios
                ],

                // Información adicional
                'year' => [
                    'nullable',
                    'integer',
                    'min:2000',
                    'max:' . (date('Y') + 1), // Hasta el año siguiente
                ],

                // Estado
                'is_active' => 'nullable|boolean',
            ];
        }

        // ============================================
        // PUT: Actualizar proyecto existente
        // ============================================
        if ($this->isMethod('put')) {
            $projectId = $this->route('project') ? $this->route('project')->id : null;

            return [
                // Relación
                'technologies' => [
                    'nullable',
                    'array',
                ],
                'technologies.*' => [
                    'integer',
                    'exists:technologies,id',
                ],

                // Información principal
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    Rule::unique('projects', 'slug')->ignore($projectId),
                ],

                'short_description' => [
                    'nullable',
                    'string',
                    'max:500',
                ],

                'long_description' => [
                    'nullable',
                    'string',
                    'max:10000',
                ],

                // Imágenes y multimedia
                'thumbnail_image' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:2048', // 2MB
                ],

                'video_url' => [
                    'nullable',
                    'url',
                    'max:500',
                    'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/',
                ],

                // Enlaces
                'project_url' => [
                    'nullable',
                    'url',
                    'max:500',
                ],

                'repository_url' => [
                    'nullable',
                    'url',
                    'max:500',
                    'regex:/^(https?:\/\/)?(www\.)?(github\.com|gitlab\.com)\/.+$/', // Validar repositorios
                ],

                // Información adicional
                'year' => [
                    'nullable',
                    'integer',
                    'min:2000',
                    'max:' . (date('Y') + 1),
                ],

                // Estado
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

            // Title
            'title.required' => 'El título del proyecto es obligatorio.',
            'title.min' => 'El título debe tener al menos 3 caracteres.',
            'title.max' => 'El título no puede exceder los 255 caracteres.',

            // Slug
            'slug.required' => 'El slug es obligatorio.',
            'slug.max' => 'El slug no puede exceder los 255 caracteres.',
            'slug.regex' => 'El slug solo puede contener letras minúsculas, números y guiones (Ej: smart-parking-system).',
            'slug.unique' => 'Ya existe un proyecto con este slug.',

            // Short Description
            'short_description.max' => 'La descripción corta no puede exceder los 500 caracteres.',

            // Long Description
            'long_description.max' => 'La descripción completa no puede exceder los 10,000 caracteres.',

            // Thumbnail Image
            'thumbnail_image.image' => 'El archivo debe ser una imagen.',
            'thumbnail_image.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o webp.',
            'thumbnail_image.max' => 'La imagen no puede superar los 2MB.',

            // Video URL
            'video_url.url' => 'La URL del video debe ser válida.',
            'video_url.max' => 'La URL del video no puede exceder los 500 caracteres.',
            'video_url.regex' => 'La URL debe ser de YouTube (Ej: https://youtube.com/watch?v=xxx).',

            // Project URL
            'project_url.url' => 'La URL del proyecto debe ser válida.',
            'project_url.max' => 'La URL del proyecto no puede exceder los 500 caracteres.',

            // Repository URL
            'repository_url.url' => 'La URL del repositorio debe ser válida.',
            'repository_url.max' => 'La URL del repositorio no puede exceder los 500 caracteres.',
            'repository_url.regex' => 'La URL debe ser de un repositorio válido (Ej: https://github.com/usuario/repo o https://gitlab.com/usuario/repo).',

            // Year
            'year.integer' => 'El año debe ser un número entero.',
            'year.min' => 'El año debe ser 2000 o posterior.',
            'year.max' => 'El año no puede ser mayor a ' . (date('Y') + 1) . '.',

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
            'technologies' => 'tecnologías',
            'title' => 'título',
            'slug' => 'slug',
            'short_description' => 'descripción corta',
            'long_description' => 'descripción completa',
            'thumbnail_image' => 'imagen principal',
            'video_url' => 'URL del video',
            'project_url' => 'URL del proyecto',
            'repository_url' => 'URL del repositorio',
            'year' => 'año',
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

            // Auto-generar slug si no viene (solo en POST)
            if ($this->isMethod('post') && !$this->filled('slug')) {
                $data['slug'] = Str::slug($data['title']);
            }
        }

        // Normalizar slug
        if ($this->filled('slug')) {
            $data['slug'] = Str::slug($this->slug);
        }

        // Normalizar descripciones
        if ($this->filled('short_description')) {
            $data['short_description'] = trim($this->short_description);
        }

        if ($this->filled('long_description')) {
            $data['long_description'] = trim($this->long_description);
        }

        // Normalizar URLs
        foreach (['video_url', 'project_url', 'repository_url'] as $urlField) {
            if ($this->filled($urlField)) {
                $data[$urlField] = trim($this->$urlField);
            }
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
