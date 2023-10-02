const addTaskForm = document.getElementById("addTaskForm");
const createTaskDialog = document.getElementById("create-task-dialog");
const createTaskButton = document.getElementById("create-task-button");
const tableTBody = document.getElementById("tableTbody");

const createTaskButtonOpenDialog = document.getElementById(
    "create-task-button-open-dialog"
);
const createTaskButtonCloseDialog = document.getElementById(
    "create-task-button-close-dialog"
);

createTaskButtonOpenDialog.addEventListener("click", () => {
    createTaskDialog.showModal();
});

createTaskButtonCloseDialog.addEventListener("click", () => {
    createTaskDialog.close();
});

const API_PORT = 8002;

const API_URL = (port) => `http://localhost:${port}/api/v1/task`;

const HttpHandler = async ({
    resourcePath = "",
    method = "GET",
    data = null,
}) => {
    try {
        const response = await fetch(resourcePath, {
            method,
            headers: {
                "Content-Type": "application/json",
            },
            ...(data !== null &&
                !Array.isArray() &&
                typeof data === "object" && {
                    body: JSON.stringify(data),
                }),
        });

        const responseJson = await response.json();

        return responseJson;
    } catch (error) {
        return {
            ...error,
        };
    }
};

const addTask = async (dataForm) => {
    const endpointURL = `${API_URL(API_PORT)}/create`;

    const data = await HttpHandler({
        resourcePath: endpointURL,
        method: "POST",
        data: dataForm,
    });

    return data;
};

const listAllTask = async () => {
    const endpointURL = `${API_URL(API_PORT)}/get_all`;

    const data = await HttpHandler({
        resourcePath: endpointURL,
        method: "GET",
    });

    return data;
};

const taskChangeState = async (id, isEnded) => {
    const endpointURL = `${API_URL(API_PORT)}/update/${id}`;

    const data = await HttpHandler({
        resourcePath: endpointURL,
        method: "PUT",
        data: {
            isEnded,
        },
    });

    return data;
};

const deleteTask = async (id) => {
    const endpointURL = `${API_URL(API_PORT)}/delete/${id}`;

    const data = await HttpHandler({
        resourcePath: endpointURL,
        method: "DELETE"
    });

    return data;
};

const clearForm = (form) => {
    for (const input of form) {
        if (input.name && input.name !== "") {
            input.value = "";
        }
    }
};

const createRow = (task) => {
    const tr = document.createElement("tr");
    const td = document.createElement("td");

    tr.innerHTML = `
    <td>${task.title}</td>
    <td>${task.expirationDate}</td>
    <td style="color: ${task.isEnded ? "green" : "red"};">${
        task.isEnded ? "Finalizada" : "En Proceso"
    }</td>
    `;

    td.innerHTML += `
    <button id="btn-${task.id}-button-one"
    class="btn ${task.isEnded ? "btn-warning" : "btn-success"}">
        ${task.isEnded ? "Proceso" : "Finalizar"}
    </button>
    <button
        id="btn-${task.id}-button-two"
        class="btn btn-danger">Eliminar
    </button>
    `;

    const updateButton = td.querySelector(`#btn-${task.id}-button-one`);
    const deleteButton = td.querySelector(`#btn-${task.id}-button-two`);

    updateButton.addEventListener("click", async (e) => {
        e.preventDefault();
        const dataUpdated = await taskChangeState(task.id, !task.isEnded);

        if (!dataUpdated.ok) {
            alert(dataUpdated.message);
            return;
        }

        await listTable();
    });

    deleteButton.addEventListener("click", async (e) => {
        e.preventDefault();

        const dataDeleted = await deleteTask(task.id);

        if (!dataDeleted.ok) {
            alert(dataDeleted.message);
            return;
        }else{
            alert(dataDeleted.message);
        }

        await listTable();
    });

    tr.appendChild(td);

    return tr;
};

const createTable = (data = []) => {
    tableTBody.innerHTML = "";

    data.forEach((task) => {
        const row = createRow(task);

        tableTBody.appendChild(row);
    });
};

const listTable = async () => {
    const dataForTable = await listAllTask();
    if (dataForTable.ok) {
        createTable(dataForTable.data);
    }
};

addTaskForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const target = e.target;
    const dataForm = { title: "", description: "", expirationDate: "" };

    for (const input of target) {
        if (input.name && input.name !== "") {
            dataForm[input.name] = input.value;
        }
    }

    const taskAdded = await addTask(dataForm);

    if (!taskAdded.ok) {
        alert(taskAdded.message);
        return;
    }

    alert(taskAdded.message);

    clearForm(target);

    createTaskDialog.close();

    listTable();
});

(() => {
    listTable();
})();
