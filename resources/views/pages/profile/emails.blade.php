<!-- All Emails List -->
@if($emails->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($emails as $email)
            <div class="border border-gray-200 rounded-lg p-4" x-data="{ showDeleteModal: false }">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 flex-wrap">
                            <span class="text-sm font-medium text-gray-900">{{ $email->email }}</span>

                            @if($email->is_primary)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    {{ __('Primary') }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800">
                                    {{ \App\Enums\EmailType::from($email->email_type->value)->label() }}
                                </span>
                            @endif

                            @if($email->is_verified)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✓ {{ __('Verified') }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    ⏳ {{ __('Pending Verification') }}
                                </span>
                            @endif
                        </div>
                        @if($email->verified_at)
                            <p class="mt-1 text-xs text-gray-500">{{ __('Verified on') }} {{ $email->verified_at }}</p>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-2 ml-4">
                        {{--
                        @if(!$email->is_primary && $email->is_verified)
                            <!-- Set as Primary Button -->
                            <form method="POST" action="{{ route('profile.emails.set-primary', $email) }}">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-primary-600 text-xs font-medium rounded text-primary-600 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ __('Set as Primary') }}
                                </button>
                            </form>
                        @endif

                        @if(!$email->is_verified)
                            <!-- Resend Verification Button -->
                            <form method="POST" action="{{ route('profile.emails.resend', $email) }}">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                                    </svg>
                                    {{ __('Resend') }}
                                </button>
                            </form>
                        @endif

                        @if(!$email->is_primary)
                            <!-- Delete Button -->
                            <button @click="showDeleteModal = true"
                                    class="inline-flex items-center px-3 py-1.5 border border-red-300 text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                {{ __('Delete') }}
                            </button>

                            <!-- Delete Confirmation Modal -->
                            <div x-show="showDeleteModal"
                                 x-cloak
                                 class="fixed inset-0 z-50 overflow-y-auto"
                                 aria-labelledby="modal-title"
                                 role="dialog"
                                 aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <!-- Background overlay -->
                                    <div x-show="showDeleteModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                         @click="showDeleteModal = false"
                                         aria-hidden="true"></div>

                                    <!-- Modal panel -->
                                    <div x-show="showDeleteModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                    {{ __('Delete Email') }}
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">
                                                        {{ __('Are you sure you want to delete') }} <strong>{{ $email->email }}</strong>?
                                                        {{ __('This action cannot be undone.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                            <form method="POST" action="{{ route('profile.emails.delete', $email) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                            <button type="button"
                                                    @click="showDeleteModal = false"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                {{ __('Cancel') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                         --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="border border-gray-200 rounded-lg p-4 text-center text-gray-500">
        <p>{{ __('No email addresses found') }}</p>
    </div>
@endif

<!-- Change Email Form -->
{{--
<form method="POST" action="{{ route('profile.update') }}" class="border border-gray-200 rounded-lg p-4">
    @csrf
    @method('PUT')

    <!-- Copy all demographic fields as hidden -->
    <input type="hidden" name="first_name" value="{{ $demographics->first_name }}">
    <input type="hidden" name="middle_name" value="{{ $demographics->middle_name }}">
    <input type="hidden" name="last_name" value="{{ $demographics->last_name }}">
    <input type="hidden" name="date_of_birth" value="{{ $demographics->date_of_birth?->format('Y-m-d') }}">
    <input type="hidden" name="gender" value="{{ $demographics->gender?->value }}">
    <input type="hidden" name="identification_type" value="{{ $demographics->identification_type?->value }}">
    <input type="hidden" name="identification_number" value="{{ $demographics->identification_number }}">
    <input type="hidden" name="ethnicity" value="{{ $demographics->ethnicity?->value }}">
    <input type="hidden" name="preferred_language" value="{{ $demographics->preferred_language?->value }}">

    <h4 class="text-sm font-medium text-gray-900 mb-3">{{ __('Change Email Address') }}</h4>
    <div class="space-y-3">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('New Email Address') }}
            </label>
            <input id="email" name="email" type="email" required
                   value="{{ old('email', $primaryEmail->email ?? '') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('email') border-red-500 @enderror">
            @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
            <p class="text-sm text-blue-800">
                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          clip-rule="evenodd"/>
                </svg>
                {{ __('Changing your email will require verification. Your current email will remain active until the new one is verified.') }}
            </p>
        </div>

        <button type="submit"
                class="w-full px-4 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
            {{ __('Update Email Address') }}
        </button>
    </div>
</form>
--}}
