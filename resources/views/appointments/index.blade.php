@extends('layouts.dashboard')
@section('content')
    @if(Auth::user()->role == 'patient')
        
        <x-patient-appointment :appointments="$appointments"></x-patient-appointment>
    @elseif(Auth::user()->role == 'doctor')
        <x-doctor-appointment :appointments="$appointments"></x-doctor-appointment>
    @endif
@endsection
