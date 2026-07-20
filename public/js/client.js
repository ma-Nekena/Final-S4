
function ajouterChampNumero() {

    const container = document.getElementById("liste-numeros");

    if (!container) {
        return;
    }

    const ligne = document.createElement("div");

    ligne.className = "numero-row";

    ligne.innerHTML = `
        <span class="phone-icon">
            📱
        </span>

        <input
            type="text"
            name="destinataires[]"
            class="numero-input"
            placeholder="Ex : 0329988877"
            required
        >

        <button
            type="button"
            class="delete-number"
            onclick="supprimerChampNumero(this)"
        >
            ✕
        </button>
    `;

    container.appendChild(ligne);

}

function supprimerChampNumero(button) {

    const lignes = document.querySelectorAll(".numero-row");

    if (lignes.length <= 1) {

        alert("Vous devez saisir au moins un numéro destinataire.");

        return;

    }

    button.closest(".numero-row").remove();

}

function confirmerSuppression(message = "Confirmer cette suppression ?") {

    return confirm(message);

}

function retourHaut() {

    window.scrollTo({

        top: 0,

        behavior: "smooth"

    });

}

document.addEventListener("DOMContentLoaded", function () {

    console.log("Client.js chargé.");

});