@extends('layouts.app')

@section('title', 'NFTs')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <livewire:market-overview />
            </div>
            <x-market-tabs />
            <div class="mt-6">
                <livewire:nft-table />
            </div>
        </div>
    </div>
@endsection 