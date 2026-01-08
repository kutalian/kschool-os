<x-master-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
            <p class="text-gray-500">Update account details for {{ $user->username }}</p>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST"
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select name="role" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="parent" {{ $user->role == 'parent' ? 'selected' : '' }}>Parent</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div class="mt-3 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-yellow-700">
                                    <span class="font-bold">Warning:</span> Changing a user's role (e.g., from Student
                                    to Staff) will
                                    <strong>NOT</strong> automatically move or create their profile data. You may need
                                    to manually create a new profile for the new role.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">New Password (Optional)</label>
                    <input type="password" name="password"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="Leave blank to keep current">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="text-gray-700 font-medium">Account Active</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('users.index') }}"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Update
                    User</button>
            </div>
        </form>
    </div>
</x-master-layout>