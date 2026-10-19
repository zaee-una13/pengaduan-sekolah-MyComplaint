<x-dashboard-layout :role="auth()->user()->role" active="pengaturan" title="Pengaturan">

    <div class="max-w-2xl space-y-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @include('profile.partials.delete-user-form')
        </div>

    </div>

</x-dashboard-layout>