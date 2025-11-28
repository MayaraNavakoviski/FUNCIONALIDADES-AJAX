(function () {

    const form = document.getElementById("formOrdemServico");
    const msgBox = document.getElementById("msgAjax");

    function ajaxValidarStatus(status) {

        if (status === "Concluida" || status === "Cancelada") {
            msgBox.innerHTML = `
                <div class="alert alert-danger">
                    Não é permitido criar uma ordem já Concluída ou Cancelada.
                </div>
            `;
            return false;
        }
        return true;
    }

    function ajaxEnviar(formData) {

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "inserir.php", true);

        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4) {

                const resposta = xhr.responseText || "";

                if (xhr.status === 200) {

                    if (resposta.includes("Ordem cadastrada com sucesso")) {
                        msgBox.innerHTML = `
                            <div class="alert alert-success">
                                Ordem cadastrada com sucesso!
                            </div>
                        `;

                        setTimeout(() => {
                            window.location.href = "listar.php";
                        }, 1500);

                    } else {
                        msgBox.innerHTML = `
                            <div class="alert alert-danger">
                                ${resposta}
                            </div>
                        `;
                    }

                } else {
                    msgBox.innerHTML = `
                        <div class="alert alert-danger">
                            Erro na requisição AJAX. Código: ${xhr.status}
                        </div>
                    `;
                }
            }
        };

        xhr.send(formData);
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const status = formData.get("status");

        if (!ajaxValidarStatus(status)) {
            return;
        }

        ajaxEnviar(formData);
    });

})();
