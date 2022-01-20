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

function actionHandler(action, button) {
    fetch('/api/reports/' + button.value + '/' + action, { method: 'POST' })
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
            document.getElementById('r' + button.value).innerHTML = html;
            document.getElementById('dets' + button.value).classList.add('show');

            let handlebutton = document.getElementById('mark-handled' + button.value);
            handlebutton.addEventListener('click', () => actionHandler('mark-handled', handlebutton)
            );

            let deleteButton = document.getElementById('delete' + button.value);
            if (deleteButton != null) {
                deleteButton.addEventListener('click', () => actionHandler('delete', deleteButton)
                );
            }

            let blockButton = document.getElementById('block' + button.value);
            if (blockButton != null) {
                blockButton.addEventListener('click', () => actionHandler('delete', blockButton)
                );
            }

        });
}


let handledButtons = document.getElementsByClassName('mark-handled-action');
for (let handleBtn of handledButtons) {
    handleBtn.addEventListener('click', () => actionHandler('mark-handled', handleBtn));
}

let blockButtons = document.getElementsByClassName('block-action');
for (let blockBtn of blockButtons) {
    blockBtn.addEventListener('click', () => actionHandler('block', blockBtn));
}

let deleteButtons = document.getElementsByClassName('delete-action');
for (let deleteBtn of deleteButtons) {
    deleteBtn.addEventListener('click', () => actionHandler('delete', deleteBtn));
}
