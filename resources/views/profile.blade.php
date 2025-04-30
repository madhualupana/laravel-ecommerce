@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">My Profile</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-600">Name</label>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-gray-600">Email</label>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold mb-4">Account Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('password.request') }}" class="block px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded">
                        Change Password
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection