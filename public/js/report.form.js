function getReportModal(type, id) {
    if (document.getElementById('reportModal') !== null) {
        document.getElementById('report-form').action = "/api/reports/" + type + "/" + id;
        return displayModal();
    }

    fetch("/api/reports/form")
        .then((response) => response.text())
        .then((modalText) => {
            let container = document.getElementById('content');
            container.insertAdjacentHTML("afterbegin", modalText);
            document.getElementById('report-submit').addEventListener('click', submitReport);

            document.getElementById('report-form').action = "/api/reports/" + type + "/" + id;

            let modal = document.getElementById('reportModal');
            new bootstrap.Modal(modal);
            modal.addEventListener('hide.bs.modal', clearFields);

            let select = document.getElementById('report-form-select');
            select.addEventListener('input', () => { select.classList.remove('is-invalid') });

            let text = document.getElementById('report-form-description');
            text.addEventListener('focus', () => { text.classList.remove('is-invalid') });

            displayModal(type, id);
        });
}

function displayModal() {
    bootstrap.Modal.getInstance(document.getElementById('reportModal')).show();
}


function submitReport() {
    let form = document.getElementById('report-form');

    if (document.getElementById('report-form-select').value == 'placeholder') {
        document.getElementById('report-form-select').classList.add('is-invalid');
    }
    if (document.getElementById('report-form-description').value === '') {
        document.getElementById('report-form-description').classList.add('is-invalid');
    }

    if (!form.checkValidity()) {
        return;
    }

    fetch(form.action, { method: 'POST', body: new FormData(form) }).then((response) => {
        if (response.ok) {
            bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
        }
        else {
            console.log('Something went wrong!');
        }
    })
}


function clearFields() {
    document.getElementById('report-form-select').value = "placeholder";
    document.getElementById('report-form-description').value = "";
    document.getElementById('report-form').classList.remove('was-validated')
    document.getElementById('report-form').reset();
}
