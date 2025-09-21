const editBtn = document.getElementById('edit-btn');
const saveBtn = document.getElementById('save-btn');
const cancelBtn = document.getElementById('cancel-btn');
const inputs = document.querySelectorAll('input, select');
const fotoEditIcon = document.getElementById('foto-edit-icon');
const fileInput = document.getElementById('file');
const perfilFoto = document.getElementById('perfil-foto');
const formFoto = document.getElementById('form-foto'); // adicione id="form-foto" no <form> da foto

// Habilitar edição
editBtn.addEventListener('click', () => {
    inputs.forEach(input => {
        if (input.tagName === 'INPUT') input.readOnly = false;
        if (input.tagName === 'SELECT') input.disabled = false;
    });
    
    fotoEditIcon.classList.remove('d-none');
    
    editBtn.classList.add('d-none');
    saveBtn.classList.remove('d-none');
    cancelBtn.classList.remove('d-none');
});

// Cancelar edição
cancelBtn.addEventListener('click', () => {
    inputs.forEach(input => {
        if (input.tagName === 'INPUT') input.readOnly = true;
        if (input.tagName === 'SELECT') input.disabled = true;
    });
    
    fotoEditIcon.classList.add('d-none');
    
    editBtn.classList.remove('d-none');
    saveBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');
});

// Salvar alterações 
saveBtn.addEventListener('click', () => {
    inputs.forEach(input => {
        if (input.tagName === 'INPUT') input.readOnly = true;
        if (input.tagName === 'SELECT') input.disabled = true;
    });
    
    fotoEditIcon.classList.add('d-none');
    
    editBtn.classList.remove('d-none');
    saveBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');

    // Upload da imagem se tiver selecionado arquivo
    if(fileInput.files.length > 0) {
        const formData = new FormData(formFoto);
        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // para debug
            // Atualiza a imagem no front-end
            const reader = new FileReader();
            reader.onload = function(e) {
                perfilFoto.src = e.target.result;
            }
            reader.readAsDataURL(fileInput.files[0]);

            alert('Salvo com sucesso!');
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar a imagem.');
        });
    } else {
        alert('Salvo com sucesso!');
    }
});

// Contador de caracteres do campo "Sobre"
const sobreInput = document.getElementById('sobre-input');
const charCount = document.getElementById('char-count');

sobreInput.addEventListener('input', function() {
    charCount.textContent = this.value.length;
    
    if (this.value.length == 250) {
        charCount.classList.add('fw-bolder', 'text-danger');
        charCount.classList.remove('text-muted', 'text-warning');
    } else if (this.value.length > 234) {
        charCount.classList.add('text-warning');
        charCount.classList.remove('text-muted', 'fw-bolder', 'text-danger');
    } else {
        charCount.classList.add('text-muted');
        charCount.classList.remove('fw-bolder', 'text-warning', 'text-danger');
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggleTheme");
    const html = document.documentElement;
    const themeIcon = toggleBtn.querySelector("i");
    const themeText = toggleBtn.querySelector("span");

    // Carregar tema salvo no localStorage
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        html.setAttribute("data-bs-theme", savedTheme);
        updateButton(savedTheme);
    }

    toggleBtn.addEventListener("click", () => {
        const currentTheme = html.getAttribute("data-bs-theme");
        const newTheme = currentTheme === "dark" ? "light" : "dark";

        html.setAttribute("data-bs-theme", newTheme);
        localStorage.setItem("theme", newTheme);

        updateButton(newTheme);
    });

    function updateButton(theme) {
        if (theme === "dark") {
            themeIcon.className = "bi bi-sun-fill"; // sol
            themeText.textContent = "Modo Claro";
        } else {
            themeIcon.className = "bi bi-moon-fill"; // lua
            themeText.textContent = "Modo Escuro";
        }
    }
});
