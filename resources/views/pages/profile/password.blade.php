@extends('layouts.app')

@section('title', __('Change Password'))

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Change Password') }}</h1>
                <p class="mt-2 text-gray-600">{{ __('Update your password to keep your account secure') }}</p>
            </div>

            <!-- Password Change Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Current Password') }} <span class="text-red-500">*</span>
                            </label>
                            <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('current_password', 'updatePassword') border-red-500 @enderror">
                            @error('current_password', 'updatePassword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('New Password') }} <span class="text-red-500">*</span>
                            </label>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('password', 'updatePassword') border-red-500 @enderror">
                            @error('password', 'updatePassword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">{{ __('Password must be at least 8 characters') }}</p>
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Confirm New Password') }} <span class="text-red-500">*</span>
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold">{{ __('Password Requirements') }}</p>
                                    <ul class="mt-2 list-disc list-inside space-y-1">
                                        <li>{{ __('At least 8 characters long') }}</li>
                                        <li>{{ __('Must be confirmed') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('profile.edit') }}"
                               class="text-center border border-gray-300 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                {{ __('Back to Profile') }}
                            </a>
                            <button type="submit"
                                    class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 hover:cursor-pointer">
                                {{ __('Update Password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
