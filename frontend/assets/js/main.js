(() => {
    
    const titleTask = document.querySelector("#titleTask");
    const btnAddTask = document.querySelector("#btnAddTask");
    const divTasks = document.querySelector(".tasks");
    const divDoneTasks = document.querySelector(".tasks-done");
    
    const url = "http://localhost/projects/task_list/api/api.php";
    
    titleTask.focus();

    /* -------------- FUNCTIONS AND EVENTS -------------- */
    
    const eventsTasks = () => {
        
        const completeTask = document.querySelectorAll(".btn-complete");
        const backTask = document.querySelectorAll(".btn-back");
        const deleteTask = document.querySelectorAll(".deleteTask");

        function changeIcon(icon, element, typeIcon) {
            element.innerHTML = `<i class="${typeIcon} fa-${icon}"></i>`;
        }
    
        completeTask.forEach(btn => {
            btn.addEventListener('mouseenter', function (e) {
                changeIcon('check', this, 'fas');
            });
    
            btn.addEventListener('mouseout', function (e) {
                changeIcon('circle', this, 'far');
            });
        });
    
        backTask.forEach(btn => {
            btn.addEventListener('mouseenter', function (e) {
                changeIcon('circle', this, 'far');
            });
            
            btn.addEventListener('mouseout', function (e) {
                changeIcon('check', this, 'fas');
            });
            
        });

        deleteTask.forEach(btn => {
            btn.addEventListener('click', function (e) {
                destroy(this.value);
            });
        });
        
    }

    function addNewTask() {
        const data = {
            'title': titleTask.value
        }

        store(data);
        titleTask.value = '';
        titleTask.focus();
    }

    btnAddTask.addEventListener('click', addNewTask);
    titleTask.addEventListener('keyup', e => e.keyCode === 13 && addNewTask());

    /* -------------- CRUD TASKS -------------- */

    // index

    async function index() {

        await fetch(url + "?indexTask=1", {
            method: 'GET'
        })
        .then(response => response.json())
        .then(result => {

            divTasks.innerHTML = '';
            divDoneTasks.innerHTML = '';

            result.forEach((task) => {
                const endDate = new Date(task.endDate);
                const dateNow = new Date();

                const delayed = (endDate.getTime() < dateNow.getTime() && task.endDate != null);

                if (task.status === 'pending') {
                    divTasks.innerHTML += `
                        <div class="task ${(delayed) ? 'delayed' : ''}">
                            <div class="complete">
                                <button class="btn-complete" title="Marcar como Concluída">
                                    <i class="far fa-circle"></i>
                                </button>
                            </div>
                            <div class="body-task">
                                <label class="title">${task.title}</label>
                                <label class="date-end">
                                    ${(task.endDate) ? '<i class="far fa-calendar-check"></i> ' + task.endDate : ' '} 
                                    ${(delayed) ? '(Atrasada)' : '' } 
                                </label>
                            </div>
                            
                            <div class="edit">
                                <button title="Editar"><i class="fas fa-pen"></i></button>
                            </div>
                            <div class="delete">
                                <button title="Apagar" class="deleteTask" value="${task.id}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    `;
                } else {
                    divDoneTasks.innerHTML += `
                        <div class="task">
                            <div class="complete">
                                <button class="btn-back" title="Marcar como não Concluída">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                            <div class="body-task">
                                <label class="title">${task.title}</label>
                            </div>
                            <div class="delete">
                                <button title="Apagar" class="deleteTask" value="${task.id}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    `;
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });

        eventsTasks();
        
    };
    index();


    // store

    const store = async data => {

        const formData = new FormData();

        formData.append('storeTask', 1);
        formData.append('title', data.title);

        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        console.log(response);
        
        index();
    }
    
    // destroy

    const destroy = async id => {

        const formData = new FormData();
    
        formData.append('deleteTask', 1);
        formData.append('id', id);
    
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
    
        console.log(response);
    
        index();
    }
})();
