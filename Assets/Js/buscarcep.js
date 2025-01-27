function buscarCep() {
    var cep = document.querySelector("input[name='cep']").value.replace("-", "");
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.querySelector("input[name='endereco']").value = data.logradouro;
                    document.querySelector("input[name='bairro']").value = data.bairro; // Preenche o bairro
                    document.querySelector("input[name='cidade']").value = data.localidade;
                    document.querySelector("input[name='estado']").value = data.uf;
                } else {
                    alert("CEP não encontrado!");
                }
            })
            .catch(error => console.error("Erro ao buscar CEP: ", error));
    }
}