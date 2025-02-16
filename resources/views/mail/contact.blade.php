<x-mail::message>
# New Contact Form Submission

**First Name:** {{ $data['firstname'] }}  
**Last Name:** {{ $data['lastname'] }}  
**Email:** {{ $data['email'] }}  

**Message:**  
{{ $data['message'] }}

Thanks,  
{{ config('app.name') }}
</x-mail::message>

