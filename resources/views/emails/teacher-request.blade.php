@component('mail::message')
# Nueva Solicitud de Profesor

Se ha recibido una nueva solicitud para ser profesor en PinCode.

**Solicitante:** {{ $teacherRequest->user->name }} ({{ $teacherRequest->user->email }})

**Motivación:**
{{ $teacherRequest->motivation }}

**Experiencia:**
{{ $teacherRequest->experience }}

@component('mail::button', ['url' => route('teacher-request.approve', $teacherRequest)])
Aprobar Solicitud
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent 