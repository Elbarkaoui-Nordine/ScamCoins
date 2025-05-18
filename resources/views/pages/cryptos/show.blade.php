@extends('layouts.app')

@section('title', 'Crypto')

@section('content')
    <livewire:crypto-show :id="$id" />
@endsection 