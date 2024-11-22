
@extends('layouts.patient-dashboard')

@section('content')
    @if(Auth::user()->role == 'patient')
        <x-patient-content></x-patient-content>
    @elseif(Auth::user()->role == 'doctor')
        <x-doctor-content></x-doctor-content>
    @endif
@endsection
