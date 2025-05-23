@extends('layouts.app', ['title' => 'Solicitud de Profesor - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="postit-note yellow-note p-6">
            <h1 class="text-2xl font-bold mb-6 text-center">
                <i class="fas fa-chalkboard-teacher mr-2"></i>
                Solicitud para ser Profesor
            </h1>

            @if(session('success'))
                <div class="alert alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if($request && $request->status === 'pending')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Tu solicitud está siendo revisada. Te notificaremos cuando tengamos una respuesta.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($request && $request->status === 'approved')
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                ¡Felicidades! Tu solicitud ha sido aprobada. Ya puedes crear y gestionar cursos.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($request && $request->status === 'rejected')
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                Lo sentimos, tu solicitud ha sido rechazada. 
                                @if($request->admin_notes)
                                    <br>Razón: {{ $request->admin_notes }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <form action="{{ route('teacher-request.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="motivation" class="block text-sm font-medium text-gray-700 mb-2">
                            ¿Por qué quieres ser profesor?
                        </label>
                        <textarea
                            id="motivation"
                            name="motivation"
                            rows="4"
                            class="form-control @error('motivation') is-invalid @enderror"
                            placeholder="Cuéntanos por qué te gustaría ser profesor en nuestra plataforma..."
                            required
                        >{{ old('motivation') }}</textarea>
                        @error('motivation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Mínimo 100 caracteres. Sé específico sobre tus motivaciones y objetivos.
                        </p>
                    </div>

                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-700 mb-2">
                            Experiencia y conocimientos
                        </label>
                        <textarea
                            id="experience"
                            name="experience"
                            rows="4"
                            class="form-control @error('experience') is-invalid @enderror"
                            placeholder="Describe tu experiencia en el área que te gustaría enseñar..."
                            required
                        >{{ old('experience') }}</textarea>
                        @error('experience')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Mínimo 100 caracteres. Incluye tu experiencia, certificaciones y áreas de expertise.
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection 