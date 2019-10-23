@component('mail::message')
  # Contact us mail

  <p>Name: {{ $data['name'] }}</p>
  <p>Email: {{ $data['email'] }}</p>
  <p>Message: {{ $data['body'] }}</p>

@endcomponent
