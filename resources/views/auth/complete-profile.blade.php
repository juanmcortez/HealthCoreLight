@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-2xl">
        <div class="text-center mt-4 mb-8">
            <h2 class="text-3xl font-bold text-gray-900">{{ __('Complete Your Profile') }}</h2>
            <p class="mt-2 text-gray-600">{{ __('Please provide your demographic information to continue') }}</p>
        </div>

        <form method="POST" action="{{ route('profile.store') }}" class="space-y-4 p-6">
            @csrf

            <!-- Name Fields -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('First Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="first_name"
                        name="first_name"
                        type="text"
                        required
                        value="{{ old('first_name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('first_name') border-red-500 @enderror"
                        placeholder="John"
                    >
                    @error('first_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div>
                    <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Middle Name') }}
                    </label>
                    <input
                        id="middle_name"
                        name="middle_name"
                        type="text"
                        value="{{ old('middle_name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        placeholder="Michael"
                    >
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Last Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="last_name"
                        name="last_name"
                        type="text"
                        required
                        value="{{ old('last_name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('last_name') border-red-500 @enderror"
                        placeholder="Doe"
                    >
                    @error('last_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Date of Birth & Gender -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Date of Birth') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="date_of_birth"
                        name="date_of_birth"
                        type="date"
                        required
                        value="{{ old('date_of_birth') }}"
                        max="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('date_of_birth') border-red-500 @enderror"
                    >
                    @error('date_of_birth')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Gender') }} <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="gender"
                        name="gender"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('gender') border-red-500 @enderror">
                        <option>{{ __('Select ...') }}</option>
                        @foreach(App\Enums\Gender::cases() as $gender)
                            <option value="{{ $gender->value }}" @selected(old('gender') === $gender->value)>
                                {{ $gender->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('gender')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- SSN (Optional) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="ssn" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Identification type') }}
                    </label>
                    <select
                        id="identification_type"
                        name="identification_type"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('identification_type') border-red-500 @enderror">
                        <option>{{ __('Select ...') }}</option>
                        @foreach(App\Enums\IdentificationType::cases() as $IDType)
                            <option value="{{ $IDType->value }}" @selected(old('identification_type') === $IDType->value)>
                                {{ $IDType->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('identification_number')
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
                        value="{{ old('identification_number') }}"
                        pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('ssn') border-red-500 @enderror"
                        placeholder="XXX-XX-XXXX"
                    >
                    <p class="mt-1 text-xs text-gray-500">{{ __('Format: XXX-XX-XXXX') }}</p>
                    @error('identification_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ethnicity & Language -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Ethnicity -->
                <div>
                    <label for="ethnicity" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Ethnicity (Optional)') }}
                    </label>
                    <select
                        id="ethnicity"
                        name="ethnicity"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('ethnicity') border-red-500 @enderror">
                        <option>{{ __('Select ...') }}</option>
                        @foreach(App\Enums\Ethnicity::cases() as $ethnicity)
                            <option value="{{ $ethnicity->value }}" @selected(old('ethnicity') === $ethnicity->value)>
                                {{ $ethnicity->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Preferred Language -->
                <div>
                    <label for="preferred_language" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Preferred Language') }} <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="preferred_language"
                        name="preferred_language"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('preferred_language') border-red-500 @enderror">
                        <option>{{ __('Select ...') }}</option>
                        @foreach(App\Enums\PreferredLanguage::cases() as $preferred_language)
                            <option value="{{ $preferred_language->value }}" @selected(old('preferred_language') === $preferred_language->value)>
                                {{ $preferred_language->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('preferred_language')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                >
                    {{ __('Complete Profile') }}
                </button>
            </div>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                              clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">{{ __('Why do we need this information?') }}</p>
                        <p class="mt-1">{{ __('Your demographic information helps us provide better service and comply with healthcare regulations. All data is encrypted and stored securely.') }}</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
