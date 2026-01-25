<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                            <input type="text" name="title" id="title"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="document_type" class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                            <select name="document_type" id="document_type"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="Policy">Policy</option>
                                <option value="Curriculum">Curriculum</option>
                                <option value="Report">Report</option>
                                <option value="Certificate">Certificate</option>
                                <option value="Letter">Letter</option>
                                <option value="Form">Form</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="access_level" class="block text-gray-700 text-sm font-bold mb-2">Access
                                Level:</label>
                            <select name="access_level" id="access_level"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="Staff">Staff Only</option>
                                <option value="Public">Public</option>
                                <option value="Admin">Admin Only</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description"
                                class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" id="description"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="document_file" class="block text-gray-700 text-sm font-bold mb-2">File:</label>
                            <input type="file" name="document_file" id="document_file"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>