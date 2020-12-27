<?php

    class ControllerTasks 
    {
        public function index()
        {
            if (is_array($response = Tasks::index())) {
                echo json_encode($response);
            } else {
                echo json_encode(["error" => "Erro ao listar as tarefas"]);
            }
        }
        public function show($request = null)
        {
            if (isset($request['id'])) {
                if (is_array($response = Tasks::show($request['id']))) {
                    echo json_encode($response);
                } else {
                    echo json_encode(["error" => "Erro ao mostrar tarefa"]);
                }
            } else {
                echo json_encode(["error" => "Nenhum id foi enviado!"]);
            }
        }
        public function store($request = null)
        {   
            $title = (isset($request['title'])) ? $request['title'] : null;
            $description = (isset($request['description'])) ? $request['description'] : null;
            $endDate = (isset($request['endDate'])) ? $request['endDate'] : null;

            $newTask = new Tasks($title, $description, 'pending', date("Y-m-d H:i:s"), $endDate);

            if ($response = $newTask->store()) {
                echo json_encode([
                    "success" => "Tarefa adicionada!",
                    "id" => $response
                ]);
            } else {
                echo json_encode(["error" => "Erro ao adicionar uma tarefa!"]);
            }

        }
        public function update($request = null)
        {
            if (isset($request['id'])) {
                if (is_array($response = Tasks::show($request['id']))) {

                    $title = (isset($request['title'])) ? $request['title'] : $response['title'];
                    $description = (isset($request['description'])) ? $request['description'] : $response['description'];
                    $endDate = (isset($request['endDate'])) ? $request['endDate'] : $response['endDate'];
                    $status = (isset($request['status'])) ? $request['status'] : $response['status'];
        
                    $newTask = new Tasks($title, $description, $status, null, $endDate);

                    if ($response = $newTask->update($request['id'])) {
                        echo json_encode(["success" => "Tarefa editada!"]);
                    } else {
                        echo json_encode(["error" => "Erro ao editar a tarefa!"]);
                    }

                } else {
                    echo json_encode(["error" => "Tarefa não encontrada!"]);
                }
            } else {
                echo json_encode(["error" => "Nenhum id foi enviado!"]);
            }
        }
        public function destroy($request = null)
        {
            if (isset($request["id"])) {
                if (Tasks::destroy($request["id"])) {
                    echo json_encode(["success" => "Tarefa deleteda com sucesso!"]);
                } else {
                    echo json_encode(["error" => "Não foi possível excluir a tarefa!"]);
                }
            } else {
                echo json_encode(["error" => "Nenhum id foi enviado!"]);
            }
        }
    }
    