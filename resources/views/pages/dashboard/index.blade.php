@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    @foreach(\App\Models\Users\User::all() AS $user)
        <p>{{ $user }}</p><br/>
    @endforeach
@endsection
