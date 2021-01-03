<?php 
    class Tasks 
    {
        private  $title;
        private  $description;
        private  $status;
        private  $creationDate;
        private  $endDate;

        public function __construct
        (
            $title = null,
            $description = null,
            $status,
            $creationDate,
            $endDate = null
        ){
            $this->title = $title;
            $this->description = $description;
            $this->status = $status;
            $this->creationDate = $creationDate;
            $this->endDate = $endDate;
        }

        // methods

        public static function index()
        {   

            try {
                $connection = Connection::getInstance();

                $query = "SELECT id, title, status, endDate FROM tasks ORDER BY id DESC;";

                $tasks = $connection->prepare($query);

                return ($tasks->execute()) ? $tasks->fetchAll() : false;

            } catch (\Throwable $th) {
                return false;
            }

        }

        public static function show($id = null) {

            try {
                $connection = Connection::getInstance();

                $query = "SELECT * FROM tasks WHERE id = :id LIMIT 1;";

                $tasks = $connection->prepare($query);
                $tasks->bindValue(":id", $id);

                return ($tasks->execute()) ? $tasks->fetchAll() : false;
                
            } catch (\Throwable $th) {
                return false;
            }
            
        }

        public function store()
        {
            try {
                $connection = Connection::getInstance();

                $query = "INSERT INTO tasks 
                          VALUE(null, :title, :description, :status, :creationDate, :endDate);";

                $tasks = $connection->prepare($query);
                $tasks->bindValue(":title", $this->title);
                $tasks->bindValue(":description", $this->description);
                $tasks->bindValue(":status", $this->status);
                $tasks->bindValue(":creationDate", $this->creationDate);
                $tasks->bindValue(":endDate", $this->endDate);

                return ($tasks->execute()) ? $connection->lastInsertId() : false;
                
            } catch (\Throwable $th) {
                return false;
            }
        }

        public function update($id = null)
        {
            try {
                $connection = Connection::getInstance();

                $query = "UPDATE tasks SET 
                          title = :title,
                          description = :description, 
                          status = :status,
                          endDate = :endDate
                          WHERE id = :id;
                        ";

                $tasks = $connection->prepare($query);
                $tasks->bindValue(":title", $this->title);
                $tasks->bindValue(":description", $this->description);
                $tasks->bindValue(":status", $this->status);
                $tasks->bindValue(":endDate", $this->endDate);
                $tasks->bindValue(":id", $id);
                $tasks->execute();

                return ($tasks->rowCount());
                
            } catch (\Throwable $th) {
                return false;
            }
        }

        public static function destroy($id = null) {
            try {
                $connection = Connection::getInstance();

                $query = "DELETE FROM tasks WHERE id = :id;";

                $tasks = $connection->prepare($query);
                $tasks->bindValue(":id", $id);
                $tasks->execute();

                return ($tasks->rowCount());

            } catch (\Throwable $th) {
                return false;
            }
        }

    }
    