<div class="p-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Member Verification Scanner</h2>
            
            <!-- Scanner Area -->
            <div class="mb-4">
                <div id="reader" class="w-full h-64 border-2 border-gray-300 rounded-lg"></div>
            </div>

            <!-- Results Area -->
            @if(isset($verificationResult) && $verificationResult)
                <div class="mt-4 p-4 rounded-lg {{ $verificationResult['status'] === 'valid' ? 'bg-green-100' : 'bg-red-100' }}">
                    @if($verificationResult['status'] === 'valid')
                        <div class="text-green-800">
                            <h3 class="font-bold text-lg">Valid Member</h3>
                            @if($verificationResult['member']['photo_url'])
                                <div class="mt-2 mb-4">
                                    <img src="{{ $verificationResult['member']['photo_url'] }}" 
                                         alt="Member Photo" 
                                         class="w-32 h-32 rounded-full object-cover mx-auto">
                                </div>
                            @endif
                            <p class="mt-2"><strong>Name:</strong> {{ $verificationResult['member']['name'] }}</p>
                            <p><strong>Membership Number:</strong> {{ $verificationResult['member']['membership_number'] }}</p>
                            <p><strong>Email:</strong> {{ $verificationResult['member']['email'] }}</p>
                        </div>
                    @else
                        <div class="text-red-800">
                            <h3 class="font-bold text-lg">Verification Failed</h3>
                            <p class="mt-2">{{ $verificationResult['message'] }}</p>
                        </div>
                    @endif
                </div>
            @endif

            @if(isset($error) && $error)
                <div class="mt-4 p-4 bg-red-100 rounded-lg text-red-800">
                    <p>{{ $error }}</p>
                </div>
            @endif

            <!-- Reset Button -->
            <div class="mt-4">
                <button wire:click="resetScanner" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Scan Another Code
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        @this.dispatch('qr-code-scanned', { data: decodedText });
    }

    function onScanFailure(error) {
        // Handle scan failure, usually better to ignore and keep scanning.
        console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    Livewire.on('reset-scanner', () => {
        html5QrcodeScanner.clear();
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
</script>
@endpush
