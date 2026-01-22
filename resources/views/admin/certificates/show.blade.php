<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Certificate Details</h1>
        <div>
            <button onclick="window.print()"
                class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition mr-2">
                <i class="fas fa-print mr-2"></i> Print
            </button>
            <a href="{{ route('certificates.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

    <div
        class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-4xl mx-auto print:shadow-none print:border-none">
        <div class="text-center border-b-2 border-gray-200 pb-8 mb-8">
            <h2 class="text-3xl font-serif font-bold text-gray-900 mb-2">Certificate of Completion</h2>
            <p class="text-gray-500 uppercase tracking-widest text-sm">{{ $certificate->certificate_type }}</p>
        </div>

        <div class="px-8 py-4 text-center">
            <p class="text-lg text-gray-600 mb-2">This is to certify that</p>
            <h3 class="text-4xl font-serif text-blue-900 font-bold mb-4 italic">{{ $certificate->student->name }}</h3>
            <p class="text-lg text-gray-600 mb-8">has successfully completed the requirements for the above mentioned
                certificate.</p>

            <div class="text-left bg-gray-50 p-6 rounded-lg mb-8">
                <p class="text-sm font-bold text-gray-500 uppercase mb-2">Additional Details</p>
                <p class="text-gray-800">{{ $certificate->content ?? 'No additional remarks.' }}</p>
            </div>

            <div class="flex justify-between items-end mt-16 px-12">
                <div class="text-center">
                    <p class="text-sm text-gray-500 mb-1">{{ $certificate->issue_date->format('F d, Y') }}</p>
                    <div class="h-px w-32 bg-gray-400 mx-auto mb-2"></div>
                    <p class="text-sm font-bold text-gray-700">Date Issued</p>
                </div>

                <div class="text-center">
                    <div
                        class="h-16 w-16 mx-auto mb-2 border-2 border-blue-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-stamp text-blue-900 text-2xl"></i>
                    </div>
                    <p class="text-xs text-blue-900 uppercase font-bold tracking-wider">Official Seal</p>
                </div>

                <div class="text-center">
                    <div class="h-px w-40 bg-gray-400 mx-auto mb-2 mt-5"></div>
                    <p class="text-sm font-bold text-gray-700">Authority Signature</p>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400 font-mono">
            Certificate Code: {{ $certificate->unique_code }}
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .max-w-4xl,
            .max-w-4xl * {
                visibility: visible;
            }

            .max-w-4xl {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
                border: none;
            }
        }
    </style>
</x-master-layout>