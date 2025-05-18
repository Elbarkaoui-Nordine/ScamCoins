@extends('layouts.app')

@section('title', 'NFT')

@section('content')
    <livewire:nft-show :id="$id" />
@endsection 