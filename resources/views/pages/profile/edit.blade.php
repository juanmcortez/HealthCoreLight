@extends('layouts.app')

@section('title', __('My Profile'))

@section('content')
    <div class="mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('My Profile') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('Manage your personal information and account settings') }}</p>
        </div>

        <!-- Tabs -->
        <div x-data="{ activeTab: 'personal' }" class="space-y-6">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button
                        @click="activeTab = 'personal'"
                        :class="activeTab === 'personal' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('Personal Information') }}
                    </button>
                    <button
                        @click="activeTab = 'email'"
                        :class="activeTab === 'email' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Email Management') }}
                    </button>
                    <button
                        @click="activeTab = 'security'"
                        :class="activeTab === 'security' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        {{ __('Security') }}
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-lg shadow">
                <!-- Personal Information Tab -->
                <div x-show="activeTab === 'personal'" x-transition>
                    <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Account Information (Read-only) -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Account Information') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Username') }}</label>
                                    <p class="w-full px-2 pb-3 text-gray-400">{{ $user->username }}</p>
                                    {{-- <p class="mt-1 text-xs text-gray-500">{{ __('Username cannot be changed') }}</p> --}}
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Primary Email') }}</label>
                                    <p class="w-full px-2 pb-3 text-gray-400">{{ $primaryEmail->email ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Current role') }}</label>
                                    <p class="w-full px-2 pb-3 text-gray-400">{{ $user->roles->first()->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Member Since') }}</label>
                                    <p class="w-full px-2 pb-3 text-gray-400">{{ $user->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Name Fields -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Personal Details') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('First Name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="first_name"
                                        name="first_name"
                                        type="text"
                                        required
                                        value="{{ old('first_name', $demographics->first_name) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('first_name') border-red-500 @enderror"
                                        placeholder="{{ __('First Name') }}"
                                    />
                                    @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Middle Name') }}
                                    </label>
                                    <input
                                        id="middle_name"
                                        name="middle_name"
                                        type="text"
                                        value="{{ old('middle_name', $demographics->middle_name) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                        placeholder="{{ __('Middle Name') }}"
                                    />
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Last Name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="last_name"
                                        name="last_name"
                                        type="text"
                                        required
                                        value="{{ old('last_name', $demographics->last_name) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('last_name') border-red-500 @enderror"
                                        placeholder="{{ __('Last Name') }}"
                                    >
                                    @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Date of Birth, Gender, Identification, Language & Ethnicity -->
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 pb-6 border-b border-gray-200">
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Date of Birth') }} <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="date_of_birth"
                                    name="date_of_birth"
                                    type="date"
                                    required
                                    value="{{ old('date_of_birth', $demographics->date_of_birth?->format('Y-m-d')) }}"
                                    max="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('date_of_birth') border-red-500 @enderror"
                                >
                                @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Gender') }} <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="gender"
                                    name="gender"
                                    required
                                    class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('gender') border-red-500 @enderror">
                                    <option value="">{{ __('Select ...') }}</option>
                                    @foreach(App\Enums\Gender::cases() as $gender)
                                        <option value="{{ $gender->value }}" @selected(old('gender', $demographics->gender?->value) === $gender->value)>
                                            {{ $gender->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ssn" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Identification type') }}
                                </label>
                                <select
                                    id="identification_type"
                                    name="identification_type"
                                    class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('identification_type') border-red-500 @enderror">
                                    <option value="">{{ __('Select ...') }}</option>
                                    @foreach(App\Enums\IdentificationType::cases() as $IDType)
                                        <option
                                            value="{{ $IDType->value }}" @selected(old('identification_type', $demographics->identification_type?->value) === $IDType->value)>
                                            {{ $IDType->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('identification_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ssn" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Identification Number') }}
                                </label>
                                <input
                                    id="identification_number"
                                    name="identification_number"
                                    type="text"
                                    value="{{ old('identification_number', $demographics->identification_number) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('identification_number') border-red-500 @enderror"
                                    placeholder="Enter your identification number"
                                >
                                <p class="mt-1 text-xs text-gray-500" id="id-number-hint">{{ __('Enter the number for your selected ID type') }}</p>
                                @error('identification_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ethnicity" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Ethnicity (Optional)') }}
                                </label>
                                <select
                                    id="ethnicity"
                                    name="ethnicity"
                                    class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('ethnicity') border-red-500 @enderror">
                                    <option value="">{{ __('Select ...') }}</option>
                                    @foreach(App\Enums\Ethnicity::cases() as $ethnicity)
                                        <option
                                            value="{{ $ethnicity->value }}" @selected(old('ethnicity', $demographics->ethnicity?->value) === $ethnicity->value)>
                                            {{ $ethnicity->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ethnicity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="preferred_language" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Preferred Language') }} <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="preferred_language"
                                    name="preferred_language"
                                    required
                                    class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('preferred_language') border-red-500 @enderror">
                                    <option value="">{{ __('Select ...') }}</option>
                                    @foreach(App\Enums\PreferredLanguage::cases() as $preferred_language)
                                        <option
                                            value="{{ $preferred_language->value }}" @selected(old('preferred_language', $demographics->preferred_language?->value) === $preferred_language->value)>
                                            {{ $preferred_language->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('preferred_language')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden email field (will be shown in Email Management tab) -->
                        <input type="hidden" name="email" value="{{ $primaryEmail->email ?? '' }}">

                        <!-- Submit Button -->
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <button
                                type="submit"
                                class="text-base bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 hover:cursor-pointer"
                            >
                                {{ __('Update Profile') }}
                            </button>
                        </div>

                    </form>
                </div>

                <!-- Email Management Tab -->
                <div x-show="activeTab === 'email'" x-transition class="p-6 space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Email Addresses') }}</h3>

                    @include('pages.profile.emails')
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" x-transition class="p-6 space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Security') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Password Change -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">{{ __('Password') }}</h4>
                            <p class="text-sm text-gray-600 mt-4">{{ __('Click here to change your password and to keep your account secure.') }}</p>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <a href="{{ route('profile.password') }}"
                                   class="text-base text-center border border-gray-300 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                    {{ __('Change Password') }}
                                </a>
                            </div>
                        </div>

                        <!-- Account Deletion -->
                        <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                            <h4 class="text-sm font-medium text-red-900 mb-2">{{ __('Delete Account') }}</h4>
                            <p class="text-sm text-red-700 mt-4">{{ __('Permanently delete your account and all the associated data.') }}</p>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <a href="{{ route('profile.delete.show') }}"
                                   class="text-base text-center border border-red-300 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                    {{ __('Delete Account') }}
                                </a>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">&nbsp;</div>

                        <div class="border border-gray-200 rounded-lg p-4">&nbsp;</div>

                    </div>
                </div>

            </div>
        </div>
@endsection
