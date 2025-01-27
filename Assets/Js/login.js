document.addEventListener("DOMContentLoaded", function () {
    const cpfInput = document.getElementById("cpf"); // Apenas no campo da consulta de garantia
    const emailInput = document.getElementById("email");
    const garantiaInput = document.getElementById("garantia");
    const senhaInput = document.getElementById("senha");
    const togglePasswordBtn = document.getElementById("togglePassword");

    // Máscara de CPF apenas para a consulta de garantia
    if (cpfInput && garantiaInput) {
        cpfInput.addEventListener("input", function () {
            let value = cpfInput.value.replace(/\D/g, "");
            value = value.replace(/^(\d{3})(\d)/, "$1.$2");
            value = value.replace(/^(\d{3})\.(\d{3})(\d)/, "$1.$2.$3");
            value = value.replace(/\.(\d{3})(\d)/, ".$1-$2");
            cpfInput.value = value;
        });
    }

    // Validação de e-mail
    if (emailInput) {
        emailInput.addEventListener("input", function () {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                emailInput.style.borderColor = "red";
            } else {
                emailInput.style.borderColor = "green";
            }
        });
    }

    // Validação de número de garantia (somente números)
    if (garantiaInput) {
        garantiaInput.addEventListener("input", function () {
            garantiaInput.value = garantiaInput.value.replace(/\D/g, "");
        });
    }

    // Alternar visibilidade da senha
    if (togglePasswordBtn && senhaInput) {
        togglePasswordBtn.addEventListener("click", function () {
            if (senhaInput.type === "password") {
                senhaInput.type = "text";
            } else {
                senhaInput.type = "password";
            }
        });
    }
});