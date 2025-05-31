@extends('layouts.app', ['title' => 'Mis Cursos Creados - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mis Cursos Creados</h1>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Crear Nuevo Curso
            </a>
        </div>

        @if($courses->isEmpty())
            <div class="text-center py-12">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-400">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">No has creado ningún curso todavía</h2>
                <p class="text-gray-600 mb-6">Comienza creando tu primer curso para compartir tu conocimiento.</p>
                <a href="{{ route('courses.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Crear Mi Primer Curso
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="course-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            <img src="{{ $course->image ? asset($course->image) : asset('images/course'.($loop->index % 3 + 1).'.png') }}" 
                                 alt="{{ $course->title }}" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2">
                                @if($course->language)
                                    <span class="badge badge-language">{{ $course->language }}</span>
                                @endif
                                <span class="badge badge-level">{{ $course->level }}</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-primary">{{ number_format($course->price, 2) }} €</span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.course-card {
    transition: transform 0.2s ease-in-out;
    border: 1px solid #e5e7eb;
}

.course-card:hover {
    transform: translateY(-5px);
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

.badge-language {
    background-color: #e0f2fe;
    color: #0369a1;
}

.badge-level {
    background-color: #fef3c7;
    color: #92400e;
}

.btn {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background-color: var(--color-primary);
    color: white;
}

.btn-outline {
    border: 1px solid var(--color-primary);
    color: var(--color-primary);
}

.btn-danger {
    background-color: #ef4444;
    color: white;
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

.btn-icon {
    margin-right: 0.5rem;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}
</style>
@endpush 