function confirmarExclusao() {

    return confirm(
        "Tem certeza que deseja excluir esta assinatura?"
    );

}

const pesquisa = document.getElementById("pesquisa");

if (pesquisa) {

    pesquisa.addEventListener("keyup", function () {

        const texto = this.value.toLowerCase();

        const linhas =
            document.querySelectorAll(
                "#tabelaAssinaturas tr"
            );

        linhas.forEach(function (linha) {

            const conteudo =
                linha.textContent.toLowerCase();

            if (conteudo.includes(texto)) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }

        });

    });

}