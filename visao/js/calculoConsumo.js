document.addEventListener('DOMContentLoaded', function() {
    const consumoInput = document.getElementById('consumo_kwh');
    const valorSpan = document.getElementById('valor_calculado');

    consumoInput.addEventListener('input', function() {
        const kwh = parseFloat(consumoInput.value) || 0;
        const valor = kwh * 0.99; // cálculo 99 centavos por kWh
        valorSpan.textContent = valor.toFixed(2).replace('.', ','); // formato brasileiro
    });
});
