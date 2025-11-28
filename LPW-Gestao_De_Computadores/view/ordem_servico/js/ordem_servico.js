function alterarStatus(id) {
    const selectElement = document.getElementById('status_os_' + id);
    const novoStatus = selectElement.value;
    const campoData = document.getElementById('data_conclusao_' + id);
    const url = '../../api/alterar_status.php';

    function enviar(status, dataConclusao = null) {

        let objetoEnvio = {
            id: id,
            status: status,
            data_conclusao: dataConclusao
        };

        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-Type", "application/json");

        xhttp.onload = function () {
            if (xhttp.status === 200) {
                let resposta = JSON.parse(xhttp.responseText);

                if (resposta.success) {
                    alert(resposta.message || "Status atualizado!");
                    window.location.reload();
                } else {
                    alert(resposta.message || "Erro ao atualizar.");
                }
            } else {
                alert("Erro ao comunicar com o servidor.");
            }
        };

        xhttp.send(JSON.stringify(objetoEnvio));
    }

    if (novoStatus === 'Concluida') {

        campoData.style.display = 'block';
        campoData.focus();

        campoData.addEventListener("change", function enviarData() {

            const dataConclusao = campoData.value;
            const hoje = new Date().toISOString().split("T")[0];
            const dataEntrada = campoData.getAttribute("min");

            if (!dataConclusao) {
                alert("A data de conclusão é obrigatória.");
                return;
            }

            if (dataConclusao > hoje) {
                alert("Data não pode ser no futuro.");
                campoData.value = "";
                return;
            }

            if (dataConclusao < dataEntrada) {
                alert("Data não pode ser antes da entrada da OS.");
                campoData.value = "";
                return;
            }

            enviar(novoStatus, dataConclusao);

            campoData.removeEventListener("change", enviarData);
        });

    } else {
        enviar(novoStatus, null);
    }
}
