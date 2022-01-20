let toggles = document.getElementsByClassName('report-toggle');
for (let toggle of toggles) {
    toggle.addEventListener('click', function () {
        if (toggle.firstElementChild.classList.contains('bi-chevron-compact-down')) {
            toggle.firstElementChild.classList.remove('bi-chevron-compact-down');
            toggle.firstElementChild.classList.add('bi-chevron-compact-up');
        }
        else {
            toggle.firstElementChild.classList.remove('bi-chevron-compact-up');
            toggle.firstElementChild.classList.add('bi-chevron-compact-down');
        }
    }.bind(toggle));
}


let handledButtons = document.getElementsByClassName('mark-handled-action');
for (let handleBtn of handledButtons) {
    handleBtn.addEventListener('click', function () {
        fetch('/api/reports/' + handleBtn.value + '/mark-handled', { method: 'POST' })
            .then((response) => {
                if (response.ok) {
                    return response.text();
                }
                else {
                    //notification
                    console.log('Something went wrong!');
                }
            })
            .then((html) => {
                document.getElementById('r' + handleBtn.value).innerHTML = html;
            });
    }.bind(handleBtn));
}

let blockButtons = document.getElementsByClassName('block-action');
for (let blockBtn of blockButtons) {
    blockBtn.addEventListener('click', function () {
        fetch('/api/reports/' + blockBtn.value + '/block', { method: 'POST' })
            .then((response) => {
                if (response.ok) {
                    return response.text();
                }
                else {
                    //notification
                    console.log('Something went wrong!');
                }
            })
            .then((html) => {
                document.getElementById('r' + blockBtn.value).innerHTML = html;
            });
    }.bind(blockBtn));
}

let deleteButtons = document.getElementsByClassName('delete-action');
for (let deleteBtn of deleteButtons) {
    deleteBtn.addEventListener('click', function () {
        fetch('/api/reports/' + deleteBtn.value + '/delete', { method: 'POST' })
            .then((response) => {
                if (response.ok) {
                    return response.text();
                }
                else {
                    //notification
                    console.log('Something went wrong!');
                }
            })
            .then((html) => {
                document.getElementById('r' + deleteBtn.value).innerHTML = html;
            });
    }.bind(deleteBtn));
}

// Add event listeners to ajax content
// Modify card according to state
