document.getElementById("deleteProject").addEventListener("click", (e) => {

    if (!confirm("Êtes-vous sûr de vouloir supprimer ce projet ? ")) {
        e.preventDefault();
    }
})