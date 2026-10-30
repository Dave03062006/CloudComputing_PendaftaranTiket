<x-mail::message>
# Pendaftaran Berhasil

Halo {{ $registration->name }},

Pendaftaran tiket konser Anda berhasil disimpan.

<x-mail::panel>
**Jenis tiket:** {{ $registration->ticket_type }}  
**Jumlah:** {{ $registration->quantity }}  
**Kursi:** {{ $registration->seat }}
</x-mail::panel>

Terima kasih telah melakukan pendaftaran.

Salam,<br>
{{ config('app.name') }}
</x-mail::message>
