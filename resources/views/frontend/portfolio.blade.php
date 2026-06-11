{{-- resources/views/frontend/portfolio.blade.php --}}

@extends('frontend.layouts.app')

@section('title', __('messages.portfolio'))

@section('content')

{{-- ============================================ --}}
{{-- Incluir cada sección como componente --}}
{{-- ============================================ --}}

@include('frontend.pages.home')

@include('frontend.pages.skills')

@include('frontend.pages.projects.index')

@include('frontend.pages.documents')

@include('frontend.pages.contact')

{{-- Modal de proyectos (debe estar una sola vez) --}}
<div id="project-modal" class="project-modal hidden">
    <div class="modal-overlay" onclick="closeProjectModal()"></div>
    <div class="modal-container">
        <button class="modal-close" onclick="closeProjectModal()">
            <i class="fas fa-times"></i>
        </button>
        <div class="modal-content" id="modal-content"></div>
    </div>
</div>

@endsection

