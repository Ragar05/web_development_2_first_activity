<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TODO APPLICATION - RAMIRO GARCIA</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/welcome.css" />
</head>

<body>
    <dialog id="create-task-dialog" class="container-fluid" style="width: 600px;">
        <form class="task__form mt-2" id="addTaskForm">
            <div class="mb-3 row">
                <label for="title" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="title" name="title"
                    placeholder="Ingresa el titulo de la tarea">
            </div>
            <div class="mb-3 row">
                <label for="expirationDate" class="form-label">Fecha de vencimiento</label>
                <input type="date" class="form-control" id="expirationDate" name="expirationDate">
            </div>
            <div class="mb-3 row form-floating">
                <textarea class="form-control" placeholder="Descripcion de la tarea" id="description"
                    style="height:200px;" name="description"></textarea>
                <label for="description" class="form-label">Descripcion</label>
            </div>
            <button type="submit" id="create-task-button" class="btn btn-success">Agregar</button>
            <button type="button" id="create-task-button-close-dialog" class="btn btn-danger">Cancelar</button>
        </form>
    </dialog>

    <div class="container pt-5">
        <div class="row justify-content-end">
            <div class="col-2">
                <button id="create-task-button-open-dialog" class="btn btn-primary">Agregar Tarea</button>
            </div>
        </div>
        <div class="row text-center">
            <div class="col align-self-center">
                <h2>Gestor de tareas</h2>
            </div>
        </div>

        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Titulo</th>
                        <th scope="col">Fecha de vencimiento</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="tableTbody">
                    <tr>
                        <td>adsasd</td>
                        <td>2023-10-06</td>
                        <td style="color: red;">En Proceso</td>
                        <td>
                            <button id="btn-5f1259d9-eb49-4b15-91f2-59aac3847592"
                                class="btn btn-success">Finalizar</button>
                            <button
                                class="btn btn-danger">Eliminar
                            </button>
                        </td>
                        <td>
                            <button id="btn-${task.id}-button-one"
                                class="btn ${task.isEnded ? "btn-warning" : "btn-success"}">
                                    ${task.isEnded ? "Proceso" : "Finalizar"}
                                </button>
                            <button
                                id="btn-${task.id}-button-two"
                                class="btn btn-danger">Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/application.js"></script>
</body>

</html>
