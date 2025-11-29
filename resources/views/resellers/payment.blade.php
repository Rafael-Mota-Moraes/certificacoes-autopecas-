<x-layout>
    <x-slot:title>
        Solicitar Certificado - Pagamento
    </x-slot:title>


    <main class="flex-grow flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 mb-8">PAGAMENTO</h1>

        <div
            class="bg-white border theme-maroon-border rounded-lg shadow-md w-full max-w-md p-8 text-center flex flex-col items-center space-y-6">
            <h2 class="text-xl font-bold text-gray-800">CÓDIGO QR</h2>

            <div class="w-48 h-48 bg-gray-200 rounded-md">
                <img src="{{ $payment->pix_qr_code }}" alt="QR Code de Pagamento"
                    class="w-full h-full object-cover rounded-md">
            </div>

            <div class="relative w-full">
                <div class="flex items-center justify-center p-3 bg-gray-50 border rounded-md">
                    <p class="text-gray-600 text-xs break-all mr-4" id="qrCodeString">
                        {{ $payment->pix_emv ?? '' }}
                    </p>
                    <button onclick="copyToClipboard()" title="Copiar código"
                        class="flex-shrink-0 text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                    </button>
                </div>
                <div id="copy-success" class="absolute -bottom-6 right-0 text-xs text-green-600 font-medium hidden">
                    Copiado!</div>
            </div>

            <p class="text-sm text-gray-500" id="expiration-timer"
                data-expires-at="{{ $payment->payment_expires_at ? $payment->payment_expires_at->toISOString() : '' }}">
                O código expira em <span id="countdown">--:--</span>
            </p>

            <p class="text-3xl font-bold text-gray-900">R$
                {{ number_format(($payment->amount ?? 0) / 100, 2, ',', '.') }}
            </p>

            <a href="{{ route('resellers.show', $reseller) }}" style="padding: 10px"
                class="w-full text-center text-white bg-[#840032] rounded-md">
                Já paguei
            </a>
        </div>
    </main>

    @push('scripts')
        <script>
            function copyToClipboard() {
                const textarea = document.createElement('textarea');
                const textToCopy = document.getElementById('qrCodeString').innerText;
                const successMessage = document.getElementById('copy-success');

                if (!textToCopy) return;

                textarea.value = textToCopy;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);

                successMessage.classList.remove('hidden');
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                }, 2000);
            }

            const timerElement = document.getElementById('expiration-timer');
            const countdownElement = document.getElementById('countdown');
            const expiresAtRaw = timerElement.dataset.expiresAt;

            if (timerElement && expiresAtRaw) {
                const expiresAt = new Date(expiresAtRaw);

                const updateCountdown = () => {
                    const now = new Date();
                    const difference = expiresAt - now;

                    if (difference <= 0) {
                        countdownElement.textContent = "Expirado";
                        alert("O código PIX expirou. Por favor, gere um novo.");
                        clearInterval(countdownInterval);
                        window.location.href = "{{ route('resellers.show', $reseller) }}";
                        return;
                    }

                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                    countdownElement.textContent =
                        `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                }

                const countdownInterval = setInterval(updateCountdown, 1000);
                updateCountdown();
            } else {
                countdownElement.textContent = "Indefinido";
            }
        </script>
    @endpush
</x-layout>
