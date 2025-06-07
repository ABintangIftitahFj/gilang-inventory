<script>
// Script untuk menguji API barcode
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = window.location.origin;
    const testUrls = [
        '/api/check-barcode',
        '/api/v1/barcode/check', 
        `${baseUrl}/api/check-barcode`,
        `${baseUrl}/api/v1/barcode/check`
    ];
    
    const testBarcode = '123456789';
    const results = document.getElementById('results');
    
    async function testEndpoints() {
        results.innerHTML = '<h4>Memulai pengujian API...</h4>';
        
        for (const url of testUrls) {
            try {
                results.innerHTML += `<p>Menguji endpoint: ${url}</p>`;
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ barcode: testBarcode })
                });
                
                const data = await response.json();
                results.innerHTML += `<p style="color:green">✓ Status: ${response.status}</p>`;
                results.innerHTML += `<p>Response: ${JSON.stringify(data)}</p>`;
            } catch (error) {
                results.innerHTML += `<p style="color:red">✗ Error: ${error.message}</p>`;
            }
            
            results.innerHTML += '<hr>';
        }
    }
    
    // Tambahkan button
    const testButton = document.createElement('button');
    testButton.textContent = 'Uji API Barcode';
    testButton.className = 'btn btn-primary';
    testButton.addEventListener('click', testEndpoints);
    
    document.body.insertBefore(testButton, results);
});
</script>
<div id="results" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"></div>
