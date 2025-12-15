@extends('layouts.app')

@section('title', __('Delete Account'))

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Delete Account') }}</h1>
                <p class="mt-2 text-gray-600">{{ __('Permanently delete your account and all associated data') }}</p>
            </div>

            <!-- Warning Box -->
            <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                              clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-red-800">
                        <p class="font-bold text-base mb-2">{{ __('Warning: This action cannot be undone!') }}</p>
                        <p class="mb-3">{{ __('Deleting your account will:') }}</p>
                        <ul class="list-disc list-inside space-y-1 mb-3">
                            <li>{{ __('Permanently delete your profile and personal information') }}</li>
                            <li>{{ __('Remove all your email addresses from our system') }}</li>
                            <li>{{ __('Revoke access to all features and services') }}</li>
                            <li>{{ __('This action is irreversible') }}</li>
                        </ul>
                        <p class="font-semibold">{{ __('Please be certain before proceeding.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Deletion Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('profile.destroy') }}" x-data="{ confirmed: false }">
                    @csrf
                    @method('DELETE')

                    <div class="space-y-6">
                        <!-- Password Confirmation -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Confirm Your Password') }} <span class="text-red-500">*</span>
                            </label>
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('password') border-red-500 @enderror">
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">{{ __('Enter your password to confirm account deletion') }}</p>
                        </div>

                        <!-- Confirmation Checkbox -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="confirm_deletion" name="confirm_deletion" type="checkbox" required
                                       x-model="confirmed"
                                       class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500 @error('confirm_deletion') border-red-500 @enderror">
                            </div>
                            <div class="ml-3">
                                <label for="confirm_deletion" class="text-sm font-medium text-gray-700">
                                    {{ __('I understand that this action is permanent and cannot be undone') }} <span class="text-red-500">*</span>
                                </label>
                                @error('confirm_deletion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('profile.edit') }}"
                               class="text-center border border-gray-300 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                {{ __('Back to Profile') }}
                            </a>
                            <button type="submit"
                                    :disabled="!confirmed"
                                    :class="confirmed ? 'from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 cursor-pointer hover:shadow-xl hover:-translate-y-0.5' : 'bg-gray-400 cursor-not-allowed'"
                                    class="bg-gradient-to-r text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition-all duration-200 transform">
                                {{ __('Delete My Account') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
