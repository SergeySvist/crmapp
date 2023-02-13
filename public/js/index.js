import * as Interface from './interface.js';

export const mdlElem = document.querySelector('#mdl_create_worker');
export const statusOnImg = 'img/green_led.png';
export const statusOffImg = 'img/red_led.png';

const btnCreateWorker = document.querySelector("#btn_create_worker");
const btnModalSave = mdlElem.querySelector('#btn_save_worker');


btnCreateWorker.addEventListener('click', Interface.btnCreateWorkerHandler);
btnModalSave.addEventListener('click', Interface.btnModalSaveWorkerHandler);
document.querySelector('#tbl_body_workers').addEventListener('click', Interface.workerHandler);
