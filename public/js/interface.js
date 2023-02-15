import * as Fetches from './fetches.js';
import { mdlElem } from './index.js';
import { statusOnImg } from './index.js';
import { statusOffImg } from './index.js';

export function findTrByWorkerId(workerId){
    const tbody = document.querySelector('#tbl_workers > tbody');
    const trs = tbody.querySelectorAll('tr');
    let tr = null;
    for (const trsKey of trs) {
        if (trsKey.dataset.workerId === workerId){
            tr = trsKey;
            break;
        }
    }
    return tr;
}

export function addTableRow(data) {
    const tbody = document.querySelector('#tbl_workers > tbody');
    const tr = tbody.querySelector('tr');

    const row = tr.cloneNode(true);
    const tds = row.querySelectorAll('td');
    console.log(data)
    row.dataset.workerId = data.id;
    tds[0].textContent = data.first_name;
    tds[1].textContent = data.last_name;
    tds[2].textContent = data.phone;
    tds[3].querySelector('img').setAttribute('src', data.status ? statusOnImg : statusOffImg);
    tds[4].textContent = data.salary;

    tbody.appendChild(row);
}

export function updateTableRow(data) {
    const tr = findTrByWorkerId(data['id']);

    const tds = tr.querySelectorAll('td');
    tds[0].textContent = data.first_name;
    tds[1].textContent = data.last_name;
    tds[2].textContent = data.phone;
    tds[3].querySelector('img').setAttribute('src', data.status ? statusOnImg : statusOffImg);
    tds[4].textContent = data.salary;
}

export function deleteTableRow(workerId) {
    const tr = findTrByWorkerId(workerId);
    console.log("delete");
    tr.remove();
}

export function showToast(delay = 2000) {
    const toast = new bootstrap.Toast(document.querySelector('#live_toast'));
    console.log(toast);

    toast.delay = delay;
    toast.autohide = true;
    toast.animation = true;
    toast.show();
}

export function showModal(worker) {
    const mode = worker ? 'update' : 'create';
    mdlElem.dataset.mode = mode;
    mdlElem.dataset.workerId = worker ? worker.id : null;

    const modal = bootstrap.Modal.getInstance(mdlElem) ?? new bootstrap.Modal(mdlElem);

    if (mode === 'update') {
        mdlElem.querySelector('#first_name').value = worker.first_name ?? "";
        mdlElem.querySelector('#last_name').value = worker.last_name ?? "";
        mdlElem.querySelector('#phone').value = worker.phone ?? "";
        mdlElem.querySelector('#salary').value = worker.salary ?? "";
        mdlElem.querySelector('#status').checked = worker.status;
    }

    modal.show();
}

export function hideModal() {
    const modal = bootstrap.Modal.getInstance(mdlElem);

    mdlElem.querySelectorAll('input').forEach(i => {
        if (i.type === 'checkbox')
            i.checked = false;
        else
            i.value = '';
    });

    modal.hide();
}
export function btnCreateWorkerHandler() {
    showModal();
}

export async function btnModalSaveWorkerHandler() {
    const modalMode = mdlElem.dataset.mode;

    const data = {};
    mdlElem.querySelectorAll('input').forEach(i => {
        data[i.name] = i.type === 'checkbox' ? i.checked : i.value;
    });
    console.log(modalMode);
    if (modalMode === 'create') {
        const response = await Fetches.fetchCreateWorker(data);

        data['id'] = await response.text();

        if (response.status === 201) {
            addTableRow(data);
            hideModal();
            showToast();
        }
    } else if (modalMode === 'update') {
        const response = await Fetches.fetchUpdateWorker(mdlElem.dataset.workerId, data);

        data['id'] = mdlElem.dataset.workerId;
        if (response.status === 203) {
            updateTableRow(data);
            hideModal();
            showToast();
        }
    }
}

export async function workerHandler(e) {
    if (e.target.tagName === 'BUTTON' || e.target.parentElement.tagName === 'BUTTON') {
        const tr = e.target.closest('tr');
        const workerId = tr.dataset.workerId;

        const button = e.target.tagName === 'BUTTON' ? e.target : e.target.parentElement;
        const action = button.dataset.action;
        let response ;
        try {
            switch (action)
            {
                case 'edit':
                    response = await Fetches.fetchGetWorker(workerId);
                    const worker = await response.json();
                    showModal(worker);
                    break;
                case 'delete':
                    response = await Fetches.fetchDeleteWorker(workerId);

                    if (response.status === 203) {
                        deleteTableRow(workerId);
                        showToast();
                    }
                    break;
            }
        } catch
        {
            // TODO:...
        }
    }
}