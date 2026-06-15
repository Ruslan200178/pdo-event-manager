@extends('layouts.app')

@title('My Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Profile Settings</h1>
            <p class="text-xs text-gray-500">Update your account name, email, credentials and avatar profile photo.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Main Settings Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 md:p-8 space-y-6">
                <!-- User Profile Photo Header -->
                <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-govblue-100 bg-govblue-50 flex items-center justify-center relative shadow-md flex-shrink-0">
                        @if(auth()->user()->photo)
                            <img id="avatar-preview" src="{{ asset(auth()->user()->photo) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <div id="avatar-placeholder" class="w-full h-full flex items-center justify-center font-bold text-govblue-800 text-3xl">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <img id="avatar-preview" src="#" alt="Avatar" class="hidden w-full h-full object-cover">
                        @endif
                    </div>
                    
                    <div class="text-center sm:text-left">
                        <h3 class="font-bold text-gray-800 text-lg">Official Photo</h3>
                        <p class="text-xs text-gray-400 mt-1">Accepts JPEG, PNG, or JPG. Max file size: 2MB.</p>
                        
                        <div class="mt-3 flex flex-wrap gap-2 justify-center sm:justify-start">
                            <label class="px-3.5 py-1.5 bg-govblue-900 text-white rounded-lg text-xs font-semibold hover:bg-govblue-950 cursor-pointer shadow-sm transition-colors duration-150">
                                <span>Choose Photo</span>
                                <input type="file" name="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Account Information Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-700 tracking-wide">Officer Full Name</label>
                        <div class="mt-1.5 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-gray-400 text-xs"></i>
                            </div>
                            <input type="text" name="name" id="name" required value="{{ old('name', auth()->user()->name) }}" class="block w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 tracking-wide">Official Email Address</label>
                        <div class="mt-1.5 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-400 text-xs"></i>
                            </div>
                            <input type="email" name="email" id="email" required value="{{ old('email', auth()->user()->email) }}" class="block w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-key text-govblue-600"></i>
                        <span>Change Security Password</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-xs font-semibold text-gray-700 tracking-wide">New Password <span class="text-gray-400 font-normal">(Leave blank if unchanged)</span></label>
                            <div class="mt-1.5 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400 text-xs"></i>
                                </div>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="block w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 tracking-wide">Confirm New Password</label>
                            <div class="mt-1.5 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400 text-xs"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="block w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Save Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            
            preview.src = reader.result;
            preview.classList.remove('hidden');
            
            if(placeholder) {
                placeholder.classList.add('hidden');
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
