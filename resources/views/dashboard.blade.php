@extends('layouts.dashboard')
@php
$appointments = $appointments ?? collect();
@endphp
@section('content')
@if(Auth::user()->role == 'patient')
<x-patient-content :appointments="$appointments" :count="$count"></x-patient-content>
@elseif(Auth::user()->role == 'doctor')
<x-doctor-content :appointments="$appointments"></x-doctor-content>
@endif
@endsection