@component('mail::message')
# Invitación para enseñar en linea

Con tus habilidades puedes ser el indicado para esta propuesta.

@component('mail::button', ['color' => 'success', 'url' => $url])
Ir a ver
@endcomponent

@endcomponent
