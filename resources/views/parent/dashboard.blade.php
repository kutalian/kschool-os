<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Parent Dashboard</h1>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Child Profile Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div
                        class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-2xl font-bold">
                        S
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Student User</h3>
                        <p class="text-sm text-gray-500">Class 10A • Roll No: 1001</p>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Attendance</p>
                        <p class="font-bold text-gray-800">95%</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Result</p>
                        <p class="font-bold text-gray-800">Pass</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Fees</p>
                        <p class="font-bold text-green-600">Paid</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>