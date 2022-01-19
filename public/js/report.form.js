function getReportModal(type, id) {
    if (document.getElementById('reportModal') !== null) {
        displayModal(type, id);

    }
    else {
        fetch("/api/reports/form")
            .then((response) => response.text())
            .then((modalText) => {
                let container = document.getElementById('content');
                container.insertAdjacentHTML("afterbegin", modalText);
                new bootstrap.Modal(document.getElementById('reportModal'));

                document.getElementById('report-submit').addEventListener('click', submitReport);

                displayModal(type, id);
            });
    }

}

function displayModal(type, id) {
    document.getElementById('report-type').value = type;
    document.getElementById('report-id').value = id;

    bootstrap.Modal.getInstance(document.getElementById('reportModal')).show();
}


function submitReport() {
    let form = document.getElementById('report-form');

    fetch("/api/reports/" + form.elements["type"].value + "/" + form.elements["id"].value, { method: 'POST', body: new FormData(form) }).then((response) => {
        if (response.ok) {
            bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
        }
        else {
            console.log('Something went wrong!');
        }
    })
}
